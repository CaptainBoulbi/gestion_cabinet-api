<?php

include_once 'ConnexionDB.php';


/**
 * AuthAPI 
 * 
 * This class is used to handle the OPTIONS request and deliver the response to the client
 * It extends the ConnexionDB class to have access to the database 
 * 
 * @category API
 * @author FruitPassion
 */
class AuthAPI extends ConnexionDB
{
    private array $allowedOptions;

    /**
     * Constructor
     * 
     * @param array $allowedOptions Array of allowed options
     */
    public function __construct(array $allowedOptions)
    {
        parent::__construct();
        $this->allowedOptions = $allowedOptions;
    }

    /**
     * This function is used to handle the login request
     *
     * @param array $donnees Data sent to the server
     * @return bool|array Returns an array of data if the login is successful, otherwise it returns false
     */
    public function postLogin(array $donnees): bool|array
    {
        $sql = "SELECT * FROM `user_auth_v2` WHERE login = ?";
        return $this->selectFirst($sql, [$donnees['login']]);
    }

    /**
     * This function is used to handle the OPTIONS request
     */
    public function optionRequest(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Authorization, Accept");
        header("Access-Control-Allow-Methods: " . implode(', ', $this->allowedOptions));
        http_response_code(204);
    }

    /**
    * This function is used to deliver the response to the client after the request has been processed
    *
    * @param string $status Status of the request, either success or error
    * @param int $status_code HTTP status code
    * @param string $status_message Message to be sent to the client
    * @param array|null $data Data to be sent to the client, null if there is no data to be sent
    * @return void Nothing is returned instead the response is sent to the client in a JSON format
    */
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
