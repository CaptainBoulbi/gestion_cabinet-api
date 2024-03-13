<?php 

include_once 'jwt_utils.php';
include_once 'AuthAPI.php';

$auth_api = new AuthAPI();

$SECRET = 'secret';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Authorization, Accept");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        http_response_code(204);
        break;
    case 'GET':
        $jwt = get_bearer_token();
        if ($jwt && $jwt != 'undefined') {
            if (is_jwt_valid($jwt, $SECRET)) {
                deliverResponse('success',204, '[R204 REST AUTH] : Jeton valide');
                exit;
            } else {
                deliverResponse('error',401, '[R401 REST AUTH] : Jeton invalide');
                exit;
            }
        } else {
            deliverResponse('error',401, '[R401 REST AUTH] : Jeton requis');
            exit;
        }
    case 'POST':
        $recup = json_decode(file_get_contents('php://input'), true);
        $data = $auth_api->postLogin($recup);
        if ($data && password_verify($recup['password'], $data['password'])) {
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('login' => $recup['login'], 'role' => $data['role'], 'exp' => time() + 3600);
            
            $jwt = generate_jwt($headers, $payload, $SECRET);
            deliverResponse('success',201, '[R201 REST AUTH] : Authentification OK', $jwt);
        } else {
            deliverResponse('error',401, '[R401 REST AUTH] : Authentification échouée');
        }
        break;
    default:
        deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}

function deliverResponse($status, $status_code, $status_message, $data = null): void
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
