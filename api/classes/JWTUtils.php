<?php

class JWTUtils
{
    private string $SERVER_AUTH = 'api_med_auth.fruitpassion.fr';

	/**
	 * This function is used to check if the bearer token is valid and if the user has the required role
	 * 
	 * @param array $roles The roles required to access the resource
	 * @return array Returns infos of user if he has the required role, otherwise it dies
	 */
	public function checkRole(array $roles) : array
	{
		$infos = $this->getAndVerify();
		if(!in_array($infos['role'], $roles)){
			header("HTTP/1.1 403 Forbidden");

			header("Content-Type:application/json; charset=utf-8");
	
			header("Access-Control-Allow-Origin: *");
			$response['status'] = 'error';
			$response['status_code'] = 403;
			$response['status_message'] = '[R403 REST AUTH] : Rôle non autorisé à effectuer cette action.';
			echo json_encode($response);
			die();
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
            $response = $this->jwtConfirm($token);
			if ($response['status'] == 'success') {
				return $response['data'];
			} else {
				$this->deliverResponse('error', 401, '[R401 REST AUTH] : Jeton invalide.');
			}
        } else{
			$this->deliverResponse('error', 401, '[R401  REST AUTH] : Jeton requis.');
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
     * This function is used to verify the token
     *
     * @param string $token The token to be verified
     * @return array Returns the response from the server
     */
    private function jwtConfirm($token): array
	{

        $ch = curl_init();

		
        curl_setopt($ch, CURLOPT_URL, $this->SERVER_AUTH); // Set the URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token, // Set the Authorization header with Bearer token
        ));

        // Execute the GET request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            echo 'Error: ' . curl_error($ch);
            die();
        } else {
			curl_close($ch);
            return json_decode($response, true);
        }

    }

	/**
	 * This function is used to create a medecin in the auth server
	 * 
	 * @param array $data The data to be sent to the server containing the login and password
	 * @return ?array Returns the response from the server
	 */
	public function createMedecin(array $data) : ?array
	{
		if ($this->checkRole(["administrateur", "secretaire"])){
			$token = $this->get_bearer_token();
			return $this->jwtAction($token , "medecin", $data, 'POST'); 
		}
	}

	/**
	 * This function is used to delete a medecin in the auth server
	 * 
	 * @param string $login The data to be sent to the server containing the login and password
	 * @return ?array Returns the response from the server
	 */
	public function deleteMedecin(string $login) : ?array
	{
		if ($this->checkRole(["administrateur", "medecin"])){
			$token = $this->get_bearer_token();
			return $this->jwtAction($token , "medecin", ['login' => $login], 'DELETE'); 
		}
	}


	/**
	 * This function is used to create a usager in the auth server
	 * 
	 * @param array $data The data to be sent to the server containing the login and password
	 * @return ?array Returns the response from the server
	 */
	public function createUsager(array $data): ?array
	{
		if ($this->checkRole(["administrateur", "invite"])){
			$token = $this->get_bearer_token();
			return $this->jwtAction($token , "usager", $data, 'POST'); 
		}
	}


	/**
	 * This function is used to delete a usager in the auth server
	 * 
	 * @param string $login The data to be sent to the server containing the login and password
	 * @return ?array Returns the response from the server
	 */
	public function deleteUsager(string $login): ?array
	{
		if ($this->checkRole(["administrateur", "usager"])){
			$token = $this->get_bearer_token();
			return $this->jwtAction($token , "usager", ['login' => $login], 'DELETE'); 
		}
	}

    /**
     * This function is used to create an entity in the database
     *
     * @param string $token The token to be verified
	 * @param string $role The role of the user
	 * @param array $data The data to be sent to the server containing the login and password
     * @return array Returns the response from the server
     */
    private function jwtAction(string $token, string $role, array $data, string $method): array
	{
		$options = [
			'http' => [
				'header' => "Content-Type: application/json\r\n".
							"Authorization: Bearer " . $token ."\n",
				'method' => $method,
				'content' => json_encode($data)
			],
		];

		$context = stream_context_create($options);
		$result = file_get_contents($this->SERVER_AUTH.'/'.$role, false, $context);

		return json_decode($result, true);
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