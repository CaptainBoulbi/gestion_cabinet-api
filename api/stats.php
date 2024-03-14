<?php 

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require $rootDir . '/classes/StatAPI.php';

$stat_api = new StatAPI(['GET', 'OPTIONS']);

$arg = $_GET['arg'] ?? null;
$stat_api->checkArguments($arg);
$stat_api->checkArgumentIsString($arg);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        $stat_api->optionRequest();
        break;
        
    case 'GET':
        if ($arg == 'medecins') {
            $stat_api->getRequestMedecin();
        } elseif ($arg == 'usagers') {
            $stat_api->getRequestUsagers();
        } else {
            $stat_api->deliverResponse('error', 404, '[R404 REST API] : Aucune statistique ne correspond à cette requete');
        }
        break;
        
    default:
        $stat_api->deliverResponse('error',405, '[R401 REST AUTH] : Methodes utilisées non autorisées');
        break;
}