<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\User;
use Cake\Mailer\Mailer;

/**
 * UserActivation mailer.
 */
class UserActivationMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    //public static string $name = 'UserActivation';

    /**
     * Send activation email to user.
     *
     * @param array User $user The user data to be used in the email template.
     * @return void
     */
    public function sendActivationEmail(User $user, string $activationLink): void
    {
        $this
            ->setTo($user->email)
            ->setFrom('noreply@yourapp.com')
            ->setSubject('Activate Your Account')
            ->setEmailFormat('both')
            ->setViewVars(['link' => $activationLink])
            ->viewBuilder()
            ->setTemplate('activate_account'); // This should correspond to a template in src/Template/Email/html/activate_account.php
    }
}
