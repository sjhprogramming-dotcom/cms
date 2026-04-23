<p>Hello <?= h($user['email']) ?>,</p>

<p>Please activate your account using the link below:</p>

<p>
    <a href="<?= h($activationLink) ?>">
        Activate account
    </a>