<?php 

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/UsagerAPI.php';

$usager_api = new UsagerAPI(['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);

$arg = $_GET['arg'] ?? null;
if (isset($arg)) {
    $usager_api->checkArgumentIsInt($arg);
} 

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $usager_api->optionRequest();
        break;
        
    case 'GET':
        if (isset($arg)) {
            $usager_api->getRequestById($arg);
        } else {
            $usager_api->getRequest();
        }
        break;
        
    case 'POST':
        $usager_api->postRequest();
        break;
        
    case 'PATCH':
        $usager_api->checkArguments($arg);
        $usager_api->patchRequest($arg);
        break;
        
    case 'DELETE':
        $usager_api->checkArguments($arg);
        $usager_api->deleteRequest($arg);
        break;
        
    default:
        $usager_api->deliverResponse('error',405, '[R405 REST AUTH] : Methodes utilisées non autorisées');
        break;
}


