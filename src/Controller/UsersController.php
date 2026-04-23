<?php
declare(strict_types=1);

namespace App\Controller;

use App\Mailer\UserMailer;
use Cake\Routing\Router;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->allowUnauthenticated(['login', 'add', 'activate']);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();

        
        // If the user is logged in send them away.
        if ($result && $result->isValid()) {

            if(!$this->request->getAttribute('identity')->get('activated')) {
                $this->Authentication->logout();
                $this->Flash->error(__('Your account is not activated. Please check your email for the activation link.'));
                return $this->redirect(['action' => 'login']);
            }
            
            $target = $this->Authentication->getLoginRedirect() ?? [
                'controller' => 'Articles',
                'action' => 'index',
            ];
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    //logout method to end the user session and redirect to login page
    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->Authentication->logout();
       
        $this->Flash->success(__('you have been logged out.'));
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['Articles']);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            //Genearate activation token and set expiration time
            $user->activation_token = bin2hex(random_bytes(32)); // Generate a random token
            $user->activation_expires = date('Y-m-d H:i:s', strtotime('+1 day')); // Set expiration time to 24 hours from now
            
                // create an activation url
                $activationLink = Router::url([
                    'controller' => 'Users',
                    'action' => 'activate',
                    $user->activation_token
                ], true);

            if ($this->Users->save($user)) {

                // Send activation email
                $userMailer = new UserMailer();
                $userMailer->sendActivationEmail($user->toArray(), $activationLink);

                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     * Activate method to handle account activation via email link
     * @param string|null $token Activation token from the email link
     * @return \Cake\Http\Response|null Redirects to login page with success or error message
     */
    public function activate($token = null)
    {


        //check for token in the url
        if (!$token) {
            $this->Flash->error(__('Invalid activation token.'));
            return $this->redirect(['action' => 'login']);
        }

        //find user by activation token
        $user = $this->Users->findByActivationToken($token)->first();
        if (!$user) {
            $this->Flash->error(__('Invalid or expired activation token.'));
            return $this->redirect(['action' => 'login']);
        }

        if ($user->activation_expires < new \DateTime()) {
            $this->Flash->error(__('Activation token has expired.'));
            return $this->redirect(['action' => 'login']);
        }

        $user->activated = true;            //User becoms active
        $user->activation_token = null;     //Clear the activation token
        $user->activation_expires = null;  //Clear the activation expiration time

        if ($this->Users->save($user)) {
            $this->Flash->success(__('Your account has been activated.'));
        } else {
            $this->Flash->error(__('Failed to activate your account. Please try again.'));
        }

        return $this->redirect(['action' => 'login']);
    }
}