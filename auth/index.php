<?php 

include_once 'JWTUtils.php';
include_once 'AuthAPI.php';

$auth_api = new AuthAPI(['GET', 'POST', 'OPTIONS']);
$jwt_utils = new JWTUtils();

$SECRET = 'secret';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $auth_api->optionRequest();
        break;
    case 'GET':
        $jwt = $jwt_utils->get_bearer_token();
        if ($jwt && $jwt != 'undefined') {
            if ($jwt_utils->is_jwt_valid($jwt, $SECRET)) {
                $jwt_decoded = $jwt_utils->decode_jwt($jwt);
                $auth_api->deliverResponse('success',200, '[R200 REST AUTH] : Jeton valide', $jwt_decoded);
                exit;
            } else {
                $auth_api->deliverResponse('error',401, '[R401 REST AUTH] : Jeton invalide');
                exit;
            }
        } else {
            $auth_api->deliverResponse('error',401, '[R401 REST AUTH] : Jeton requis');
            exit;
        }
    case 'POST':
        $recup = json_decode(file_get_contents('php://input'), true);
        if (!isset($recup['login'])){
            $auth_api->deliverResponse('error',401, '[R401 REST AUTH] : Authentification échouée, login maquant');
        }
        if (!isset($recup['mdp']) and $recup['login'] != 'invite'){
            $auth_api->deliverResponse('error',401, '[R401 REST AUTH] : Authentification échouée, mot de passe manquant');
        }
        $data = $auth_api->postLogin($recup);
        if (($recup['login'] == 'invite' && $data['role'] == 'invite') || ($data && password_verify($recup['mdp'], $data['mdp']))) {
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('login' => $recup['login'], 'role' => $data['role'], 'exp' => time() + 3600);
            
            $jwt = $jwt_utils->generate_jwt($headers, $payload, $SECRET);
            $auth_api->deliverResponse('success',201, '[R201 REST AUTH] : Authentification OK', [$jwt]);
        } else {
            $auth_api->deliverResponse('error',401, '[R401 REST AUTH] : Authentification échouée, login ou mot de passe incorrect');
        }
        break;
    default:
        $auth_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}
