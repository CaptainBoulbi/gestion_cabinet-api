<?php


/*
 * JWTUtils
 * 
 * This class is used to handle the JWT token generation and validation
 * 
 * @category API
 * @author FruitPassion
 */
class JWTUtils{

	/**
	 * This function is used to generate a JWT token
	 *
	 * @param array $headers Array of headers
	 * @param array $payload Array of payload
	 * @param string $secret Secret key
	 * @return string Returns the generated JWT token
	 */
	public function generate_jwt(array $headers, array $payload, string $secret): string
	{
		$headers_encoded = $this->base64url_encode(json_encode($headers));
	
		$payload_encoded = $this->base64url_encode(json_encode($payload));
	
		$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
		$signature_encoded = $this->base64url_encode($signature);
	
		$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
	
		return $jwt;
	}
	
	/**
	 * This function is used to check if a JWT token is valid
	 *
	 * @param string $jwt JWT token
	 * @param string $secret Secret key
	 * @return bool Returns true if the token is valid, otherwise it returns false
	 */
	public function is_jwt_valid(string $jwt, string $secret) : bool
	{
		// split the jwt
		$tokenParts = explode('.', $jwt);
		$header = base64_decode($tokenParts[0]);
		$payload = base64_decode($tokenParts[1]);
		$signature_provided = $tokenParts[2];
	
		// check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
		$expiration = json_decode($payload)->exp;
		$is_token_expired = ($expiration - time()) < 0;
	
		// build a signature based on the header and payload using the secret
		$base64_url_header = $this->base64url_encode($header);
		$base64_url_payload = $this->base64url_encode($payload);
		$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
		$base64_url_signature = $this->base64url_encode($signature);
	
		// verify it matches the signature provided in the jwt
		$is_signature_valid = ($base64_url_signature === $signature_provided);
	
		if ($is_token_expired || !$is_signature_valid) {
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
}
