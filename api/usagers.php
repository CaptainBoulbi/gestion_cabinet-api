<?php 

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require $rootDir . '/classes/UsagersAPI.php';

$app_api = new AppAPI(['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);


switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $auth_api->optionRequest();
        break;
        
    case 'GET':
        break;
        
    case 'POST':
        $recup = json_decode(file_get_contents('php://input'), true);
        break;
        
    case 'PATCH':
        $recup = json_decode(file_get_contents('php://input'), true);
        break;
        
    case 'DELETE':
        break;
        
    default:
        $app_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}


