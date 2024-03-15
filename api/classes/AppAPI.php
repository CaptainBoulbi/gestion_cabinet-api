<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/ConnexionDB.php';

/**
 * AppAPI 
 * 
 * This class is used to handle the OPTIONS request and deliver the response to the client
 * It extends the ConnexionDB class to have access to the database 
 * 
 * @category API
 * @author FruitPassion
 */
class AppAPI extends ConnexionDB
{

    private array $allowedOptions;

    /**
     * Constructor
     * 
     * @param array $allowedOptions Array of allowed options
     */
    public function __construct(array $allowedOptions){
        parent::__construct();
        $this->allowedOptions = $allowedOptions;
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

        $response['status'] = $status;
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
        die();
    }

    /**
     * This function is used to check if the arguments are not empty
     * 
     * @param array $args Array of arguments
     */
    public function checkArguments($args): void
    {
        if (empty($args)) {
            $this->deliverResponse('error', 400, '[R400 REST API] : Aucun argument n\'a été fourni');
        }
    }

    /**
     * This function is used to check if the argument is an integer
     * 
     * @param mixed $arg Argument to be checked
     */
    public function checkArgumentIsInt($arg): void
    {
        if ((!is_numeric($arg)) || ($arg < 1)) {
            $this->deliverResponse('error', 400, '[R400 REST] : L\'identifiant doit être un entier positif non null');
            die();
        } elseif ($arg > 2147483647) {
            $this->deliverResponse('error', 400, '[R400 REST] : L\'identifiant doit être un entier inférieur à 2147483647');
            die();
        }
    }


    /**
     * This function is used to check if the argument is a string
     * 
     * @param mixed $arg Argument to be checked
     */
    public function checkArgumentIsString($arg): void
    {
        if (!is_string($arg)) {
            $this->deliverResponse('error', 400, '[R400 REST] : L\'argument doit être une chaine de caractère');
            die();
        }
    }
}
