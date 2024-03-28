<?php 

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require $rootDir . '/classes/JWTUtils.php';
require $rootDir . '/classes/InterractionsAPI.php';

$interaction_api = new InterractionsAPI(['DELETE', 'POST', 'OPTIONS']);


switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $interaction_api->optionRequest();
        break;
    case 'POST':
        $interaction_api->postRequest('medecin', ['administrateur', 'secretaire']);
        break;
    case 'DELETE':
        $interaction_api->deleteRequest('medecin', ['administrateur', 'medecin']);
        break;
    default:
        $interaction_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}
