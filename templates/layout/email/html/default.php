<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>

<head>
    <style>
        /* Base styles */
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: #212529;
        }

        .container {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: #0d6efd;
            color: #fff;
            padding: 22px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }

        .content {
            padding: 25px;
            font-size: 15px;
            line-height: 1.6;
        }

        .card {
            background: #ffffff;
            padding: 20px;
            border: 1px solid #e3e3e3;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .btn-primary {
            display: inline-block;
            background: #0d6efd;
            color: #ffffff !important;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6c757d;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                width: 100% !important;
            }

            .content {
                padding: 18px;
            }
        }
    </style>
    
</head>

<body>
    <div class="container">
        <div class="header">
            Welcome to Our CMS!
        </div>
        <div class="content">
        <?= $this->fetch('content') ?>
        </div>
    </div>
</body>

</html>