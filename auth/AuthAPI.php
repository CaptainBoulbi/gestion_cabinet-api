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

    public function deliverResponse($status, $status_code, $status_message, $data = null): void
    {
        http_response_code($status_code);

        header("HTTP/1.1 $status_code $status_message");

        header("Content-Type:application/json; charset=utf-8");

        header("Access-Control-Allow-Origin: *");

        $response['status'] = $status; // success or error
        $response['status_code'] = $status_code;
        $response['status_message'] = $status_message;
        if ($data){
            $response['data'] = $data;
        }

        $json_response = json_encode($response);

        if ($json_response === false) {
            die('json encode ERROR : ' . json_last_error_msg());
        }

        echo $json_response;
    }
}
