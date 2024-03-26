<?php

class JWTUtils
{
    private string $SERVER_AUTH = 'http://172.18.0.1:41066';

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

	public function createMedecin()
	{
		if ($this->checkRole(["administrateur", "secretaire"])){

		}
	}

	/**
	 * This function is used to get and verify the token
	 * 
	 * @return array Returns the data from the token, otherwise it dies
	 */
    private function getAndVerify() : array
	{
        $token = $this->get_bearer_token();
        if($token){
            $response = $this->jwtConfirm($token);
			if ($response['status'] == 'success') {
				return $response['data'];
			} else {
				header("HTTP/1.1 401 Unauthorized");

				header("Content-Type:application/json; charset=utf-8");
		
				header("Access-Control-Allow-Origin: *");
				$response['status'] = 'error';
				$response['status_code'] = 401;
				$response['status_message'] = '[R401 REST AUTH] : Jeton invalide.';
				echo json_encode($response);
				die();
			}
        } else{
			header("HTTP/1.1 401 Unauthorized");

			header("Content-Type:application/json; charset=utf-8");
		
			header("Access-Control-Allow-Origin: *");
			$response['status'] = 'error';
			$response['status_code'] = 401;
			$response['status_message'] = '[R401 REST AUTH] : Jeton requis.';
            echo json_encode($response);
            die();
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
     * This function is used to create an entity in the database
     *
     * @param string $token The token to be verified
     * @return array Returns the response from the server
     */
    private function createEntity($token): array
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
}