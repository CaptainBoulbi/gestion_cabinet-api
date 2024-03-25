<?php 

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/ConsultationAPI.php';

$consultations_api = new ConsultationAPI(['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);

$arg = $_GET['arg'] ?? null;
if (isset($arg)) {
    $consultations_api->checkArgumentIsInt($arg);
} 

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $consultations_api->optionRequest();
        break;
    
    case 'GET':
        if (isset($arg)) {
            $consultations_api->getRequestById($arg);
        } else {
            $consultations_api->getRequest();
        }
        break;
        
    case 'POST':
        $consultations_api->postRequest();
        break;
        
    case 'PATCH':
        $consultations_api->checkArguments($arg);
        $consultations_api->patchRequest($arg);
        break;
        
    case 'DELETE':
        $consultations_api->checkArguments($arg);
        $consultations_api->deleteRequest($arg);
        break;
        
    default:
        $consultations_api->deliverResponse('error',405, '[R405 REST AUTH] : Methodes utilisées non autorisées');
        break;
}



