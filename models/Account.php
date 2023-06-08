<?php

namespace Models;

class Account extends Database
{
    public function createAccount($token, $email): void
    {

        $req = "INSERT INTO `accounts`(`email`, `token`)
                VALUES (:token, :email)";

        $params = [
            'token' => $token,
            'email' => $email
        ];

        $this->generic($req, $params);
    }

    public function getAccountFromEmail($email)
    {

        $req = "SELECT `id`, `email`, `password`, `token` 
                FROM `accounts` 
                WHERE email = :email";

        $params = [
            'email' => $email
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }

    public function updateQuestStep(): void
    {
        $req = "";

        $params = [];

        $this->generic($req, $params);
    }
}
