<?php 

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require $rootDir . '/classes/MedecinAPI.php';

$medecin_api = new MedecinAPI(['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);

$arg = $_GET['arg'] ?? null;
if (isset($arg)) {
    $medecin_api->checkArgumentIsInt($arg);
} 

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $medecin_api->optionRequest();
        break;
        
    case 'GET':
        if (isset($arg)) {
            $medecin_api->getRequestById($arg);
        } else {
            $medecin_api->getRequest();
        }
        break;
        
    case 'POST':
        $medecin_api->postRequest();
        break;
        
    case 'PATCH':
        $medecin_api->checkArguments($arg);
        $medecin_api->patchRequest($arg);
        break;
        
    case 'DELETE':
        $medecin_api->checkArguments($arg);
        $medecin_api->deleteRequest($arg);
        break;
        
    default:
        $app_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}


