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

                $email = "a85434c57b-8fa285@inbox.mailtrap.io"; // DEV
                //$email = $_POST['email']; // PROD

                $token = bin2hex(random_bytes(32));
                $link = "http://localhost:3000/STAGE/admin_npc_1.1/index.php?page=activate-account&token=" . $token . "&email=" . $email;

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
            $mailer->Host = 'sandbox.smtp.mailtrap.io';
            $mailer->Port = 2525;
            $mailer->SMTPAuth = true;
            $mailer->Username = 'a7eab8014df032';
            $mailer->Password = 'da6890139d19ad';

            // Set sender and recipient
            $mailer->setFrom('sender@example.com', 'John Doe');
            $mailer->addAddress($email);

            // Set email content
            $mailer->Subject = 'Activate your account!';
            $mailer->Body = 'Activate your account by clicking onto that link:' . $link;

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
