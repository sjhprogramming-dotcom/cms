<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\View\ViewBuilder;

/**
 * Users mailer.
 */
class UserMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static string $name = 'Users';

    /**
     * Send activation email to user.
     *
     * @param array $user User data.
     * @return void
     */
    public function sendActivationEmail(array $user, string $activationLink): void
    {
        $this->viewBuilder()
            ->setTemplate('activate_account'); // Use the appropriate email template

        $this
            ->setTo($user['email'])
            ->setFrom('noreply@yourapp.com')
            ->setSubject('Activate Your Account')
            ->setViewVars(['user' => $user, 'activationLink' => $activationLink]) // Pass user data and activation link to the template
            ->setEmailFormat('both') // Send email in both HTML and text formats
            ->send();
    }


}
