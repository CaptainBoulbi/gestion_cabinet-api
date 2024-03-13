<?php 

include_once 'AppAPI.php';

$app_api = new AppAPI(['GET', 'OPTIONS']);


switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $auth_api->optionRequest();
        break;
        
    case 'GET':
        break;
        
    default:
        $app_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}


