<?php 

include_once 'AppAPI.php';

$usager_api = new AppAPI(['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);

$arg = $_GET['arg'] ?? null;
if (isset($arg)) {
    $usager_api->checkArgumentIsInt($arg);
} 

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $usager_api->optionRequest();
        break;
        
    case 'GET':
        break;
        
    case 'POST':
        break;
        
    case 'PATCH':
        break;
        
    case 'DELETE':
        break;
        
    default:
        $usager_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}


