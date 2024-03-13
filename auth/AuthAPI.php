<?php

include_once 'ConnexionDB.php';

class AuthAPI extends ConnexionDB
{
    public function __construct(){
        parent::__construct();
    }

    public function postLogin(array $donnees): bool|array
    {
        $sql = "SELECT * FROM `user_auth_v2` WHERE login = ?";
        return $this->selectFirst($sql, [$donnees['login']]);
    }
}
