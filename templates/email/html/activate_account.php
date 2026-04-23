<?php
declare(strict_types=1);
/**
 * @var string $link Activation link passed from the mailer
 */
?>

<div class="card">
    <p>Thanks for signing up! Click the button below to activate your account:</p>

    <p style="text-align:center; margin: 25px 0;">
        <a href="<?= h($link) ?>" class="btn-primary"> Activate Account</a>
    </p>

    <p>If the button doesn’t work, copy and paste this URL into your browser:</p>

    <div style="word-break: break-all; margin-top: 10px; color: #0d6efd;">
        <?= h($link) ?>
    </div>

    <p>This link expires in 24 hours.</p>
</div>