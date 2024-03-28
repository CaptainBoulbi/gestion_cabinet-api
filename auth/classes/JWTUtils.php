<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/ConnexionDB.php';

/*
 * JWTUtils
 * 
 * This class is used to handle the JWT token generation and validation
 * 
 * @category API
 * @author FruitPassion
 */
class JWTUtils extends ConnexionDB
{

	private string $SECRET = 'secret';

	/**
     * Constructor
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * This function is used to generate a JWT token
	 *
	 * @param array $headers Array of headers
	 * @param array $payload Array of payload
	 * @return string Returns the generated JWT token
	 */
	public function generate_jwt(array $headers, array $payload): string
	{
		$headers_encoded = $this->base64url_encode(json_encode($headers));
	
		$payload_encoded = $this->base64url_encode(json_encode($payload));
	
		$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $this->SECRET, true);
		$signature_encoded = $this->base64url_encode($signature);
	
		$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
	
		return $jwt;
	}

		/**
	 * This function is used to check if the bearer token is valid and if the user has the required role
	 * 
	 * @param array $roles The roles required to access the resource
	 * @return ?array Returns infos of user if he has the required role, otherwise it dies
	 */
	public function checkRole(array $roles) : ?array
	{
		$infos = $this->getAndVerify();
		if(!in_array($infos['role'], $roles)){
			$this->deliverResponse('error', 403, '[R403 REST AUTH] : Rôle non autorisé à effectuer cette action.');
		} else {
			return $infos;
		}
	}

	/**
	 * This function is used to get and verify the token
	 * 
	 * @return ?array Returns the data from the token, otherwise it dies
	 */
    private function getAndVerify() : ?array
	{
        $token = $this->get_bearer_token();
        if($token){
			if ($this->is_jwt_valid($token)) {
				return $this->decode_jwt($token);
			} else {
				$this->deliverResponse('error', 401, '[R401 REST AUTH] : Jeton invalide.');
			}
        } else{
			$this->deliverResponse('error', 401, '[R401  REST AUTH] : Jeton requis.');
		}
	}
	
	/**
	 * This function is used to check if a JWT token is valid
	 *
	 * @param string $jwt JWT token
	 * @return bool Returns true if the token is valid, otherwise it returns false
	 */
	public function is_jwt_valid(string $jwt) : bool
	{
		// split the jwt
		$tokenParts = explode('.', $jwt);
		$header = base64_decode($tokenParts[0]);
		$payload = base64_decode($tokenParts[1]);
		$signature_provided = $tokenParts[2];

		$data=json_decode($payload);
		$sql = "SELECT * FROM user_auth_v2 WHERE login = ?";
		$result = $this->selectFirst($sql, [$data->login]);
	
		// check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
		$expiration = json_decode($payload)->exp;
		$is_token_expired = ($expiration - time()) < 0;
	
		// build a signature based on the header and payload using the secret
		$base64_url_header = $this->base64url_encode($header);
		$base64_url_payload = $this->base64url_encode($payload);
		$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $this->SECRET, true);
		$base64_url_signature = $this->base64url_encode($signature);
	
		// verify it matches the signature provided in the jwt
		$is_signature_valid = ($base64_url_signature === $signature_provided);
	
		if ($is_token_expired || !$is_signature_valid || !$result) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/** 
	 * This function is used to get the bearer token from the request
	 *
	 * @return string|null Returns the bearer token if it exists, otherwise it returns null
	 */
	public function get_bearer_token() : ?string
	{
		$headers = $this->get_authorization_header();
		
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				if($matches[1]=='null') 
					return null;
				else
					return $matches[1];
			}
		}
		return null;
	}
	
	/**
	 * This function is used to decode a JWT token
	 *
	 * @param string $jwt JWT token
	 * @return array Returns the decoded payload
	 */
	public function decode_jwt($jwt) : array
	{
		$tokenParts = explode('.', $jwt);
		$payload = base64_decode($tokenParts[1]);
		return json_decode($payload, true);
	}
	
	/**
	 * This function is used to encode a string to base64url
	 *
	 * @param string $data String to be encoded
	 * @return string Returns the encoded string
	 */
	private function base64url_encode($data): string
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	/**
	 * This function is used to get the authorization header from the request
	 *
	 * @return string|null Returns the authorization header if it exists, otherwise it returns null
	 */
	private function get_authorization_header(): ?string
	{
		$headers = null;
	
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} else if (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
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
    private function deliverResponse($status, $status_code, $status_message, $data = null): void
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
}
