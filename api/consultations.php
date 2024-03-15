<?php 

include_once 'AppAPI.php';

$consultations_api = new AppAPI(['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);

$arg = $_GET['arg'] ?? null;
if (isset($arg)) {
    $consultations_api->checkArgumentIsInt($arg);
} 

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $consultations_api->optionRequest();
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
        $consultations_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}



