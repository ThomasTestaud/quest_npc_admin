<?php

namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('./vendor/autoload.php');

class AccountController
{

    private $errors = [];

    public function createAccount()
    {

        if (isset($_POST['email'])) {

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = 'The format of the email is not correct';
            }

            if (empty($this->errors)) {

                $email = $_POST['email'];

                $token = bin2hex(random_bytes(32));
                $link = DOMAIN_NAME . "index.php?page=activate-account&token=" . $token . "&email=" . $email;

                // Check if an email dosen't already exist in the ddb
                $Models = new \Models\Account();
                if (!$Models->getAccountFromEmail($email)) {
                    $this->sendMail($email, $link); // Send the email
                } else {
                    $this->errors[] = 'An account already exist for that email';
                }
            }

            if (empty($this->errors)) {

                $Models->createAccount($email, $token);

                $template = "views/create_account_success.phtml";
                require "views/layout.phtml";
                exit();
            } else {
                $errors = $this->errors;
            }
        }

        $template = "views/create_account.phtml";
        require "views/layout.phtml";
    }

    public function sendMail($email, $link)
    {
        // Instantiate PHPMailer
        $mailer = new PHPMailer(true);

        try {
            // Configure SMTP settings for Mailtrap
            $mailer->isSMTP();
            $mailer->Host = MAIL_HOST;
            $mailer->Port = MAIL_PORT;
            $mailer->SMTPAuth = MAIL_SMTP_AUTHORISATION;
            $mailer->Username = MAIL_USERNAME;
            $mailer->Password = MAIL_PASSWORD;

            // Set sender and recipient
            $mailer->setFrom(MAIL_SENDER_ADRESS, MAIL_SENDER_NAME);
            $mailer->addAddress($email);

            // Set email content
            $mailer->Subject = 'Activate your account!';
            $mailer->Body = 'Activate your account by clicking onto that link: <a href="' . $link . '">Validate your account</a>';

            // Send the email
            $mailer->send();
        } catch (Exception $e) {
            $this->errors = $mailer->ErrorInfo;
        }
    }

    public function activateAccount()
    {
        $template = "views/activate_account.phtml";
        require "views/layout.phtml";
    }
}
