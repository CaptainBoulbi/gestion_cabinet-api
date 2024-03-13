<?php 

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require $rootDir . '/classes/MedecinAPI.php';

$medecin_api = new MedecinAPI(['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS']);

$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $medecin_api->optionRequest();
        break;
        
    case 'GET':
        if (count($request) == 1) {
            $medecin_api->getRequest();
        } elseif (count($request) == 2) {
            $medecin_api->getRequestById($_GET['arg']);
        } else {
            $medecin_api->deliverResponse('error', 404, '[R404 REST API] : Ressource non trouvée');
        }
        break;
        
    case 'POST':
        $medecin_api->postRequest();
        break;
        
    case 'PATCH':
        $medecin_api->patchRequest($_GET['arg']);
        break;
        
    case 'DELETE':
        $medecin_api->deleteRequest($_GET['arg']);
        break;
        
    default:
        $app_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}


