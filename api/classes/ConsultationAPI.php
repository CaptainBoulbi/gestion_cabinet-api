<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/AppAPI.php';
require_once $rootDir . '/classes/JWTUtils.php';


/**
 * ConsultationAPI
 *
 * This class is used to manage the consultation of the database
 *
 * @category API
 * @author FruitPassion
 */
class ConsultationAPI extends AppAPI
{
    private JWTUtils $jwtu;


    /**
     * Constructor
     *
     * This constructor is used to call the parent constructor and pass the allowed options to the parent constructor
     *
     * @param array $allowedOptions Allowed options for the API
     */
    public function __construct(array $allowedOptions){
        parent::__construct($allowedOptions, ['id_usager', 'id_medecin', 'date_consult', 'heure_consult', 'duree_consult']);
        $this->jwtu = new JWTUtils();
    }

    /**
     * This function is used to handle the GET request
     */
    public function getRequest(): void
    {
        $infos_jwt = $this->jwtu->checkRole(["administrateur", "secretaire", "medecin", "usager"]);
        $sql = "SELECT * FROM consultation";
        $result = $this->selectAll($sql);
        
        if ($infos_jwt["role"] == "medecin") {
            $sql = "SELECT * FROM medecin WHERE login = ?";
            $medecin = $this->selectFirst($sql, [$infos_jwt["login"]]);
            foreach($result as $key => $consultation){
                if($consultation["id_medecin"] != $medecin["id_medecin"]){
                    unset($result[$key]);
                }
            }
        }
        
        if ($infos_jwt["role"] == "usager") {
            $sql = "SELECT * FROM usager WHERE login = ?";
            $usager = $this->selectFirst($sql, [$infos_jwt["login"]]);
            foreach($result as $key => $consultation){
                if($consultation["id_usager"] != $usager["id_usager"]){
                    unset($result[$key]);
                }
            }
        }

        if (empty($result)) {
            $this->deliverResponse('error', 404, '[R404 REST API] : Aucune consultation trouvée');
        }
        
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Consultations trouvées', $result);
        }else{
            $this->deliverResponse('error', 404, '[R404 REST API] : Aucune consultation trouvée');
        }
    }

    /**
     * This function is used to handle the GET request by id
     *
     * @param int $id Id of the consultation
     */
    public function getRequestById(int $id): void
    {
        $infos_jwt = $this->jwtu->checkRole(["administrateur", "secretaire", "medecin", "usager"]);
        $result =$this->checkConsultationExists($id);

        $this->checkRight("medecin", "[R403 REST API] : Vous n'avez pas le droit de visualiser les informations de cette consultation.", $infos_jwt, $result);
        
        $this->checkRight("usager", "[R403 REST API] : Vous n'avez pas le droit de visualiser les informations de cette consultation.", $infos_jwt, $result);

        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Consultation trouvée', $result);
        }
    }

    /**
     * This function is used to handle the POST request
     */
    public function postRequest(): void
    {
        $infos_jwt = $this->jwtu->checkRole(["administrateur", "secretaire", "medecin", "usager"]);
        $data = json_decode(file_get_contents('php://input'), true);
        
        $this->checkNeededData($data, $this->getInfos());

        $this->checkUsagerExists($data['id_usager']);
        $this->checkMedecinExists($data['id_medecin']);

        $this->checkRight("medecin", "[R403 REST API] : Vous n'avez pas le droit de créer une consultation avec un médecin différent de vous.", $infos_jwt, $data);
        
        $this->checkRight("usager", "[R403 REST API] : Vous n'avez pas le droit de créer une consultation avec un usager différent de vous.", $infos_jwt, $data);

        $this->validateDate($data['date_consult'], 'sup');

        $data['date_consult'] = $this->convertDateToMysql($data['date_consult']);

        if (!in_array($data["duree_consult"], [15, 30, 45, 60])) {
            $this->deliverResponse('error', 400, '[R400 REST API] : La durée de la consultation doit être 15, 30, 45 ou 60 minutes');
        }

        if (!preg_match('/^(0[8-9]|1[0-7]):\d\d$/', $data['heure_consult'])) {
            $this->deliverResponse('error', 400, '[R400 REST API] : L\'heure de la consultation doit être entre 08:00 et 18:00');
        }

        $this->checkMedecinAvailable($data);

        $sql = 'INSERT INTO consultation ('. implode(', ', $this->getInfos()) .') VALUES (?, ?, ?, ?, ?)';
        $id = $this->insert($sql, array_values($data));

        $result = $this->selectFirst("SELECT * FROM consultation WHERE id_consult = ?", [$id]);
        if($result){
            $this->deliverResponse('success', 201, '[R201 REST API] : Consultation ajoutée', $result);
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Echec de l\'ajout de la consultation');
        }
    }


    /**
     * This function is used to handle the PATCH request
     *
     * @param int $id Id of the consultation
     */
    public function patchRequest(int $id): void
    {
        $infos_jwt = $this->jwtu->checkRole(["administrateur", "secretaire", "medecin", "usager"]);
        $data = json_decode(file_get_contents('php://input'), true);

        $this->checkAllowedData($data, $this->getInfos());

        $result = $this->checkConsultationExists($id);
        
        $this->checkRight("medecin", "[R403 REST API] : Vous n'avez pas le droit de modifier cette consultation.", $infos_jwt, $result);
        
        $this->checkRight("usager", "[R403 REST API] : Vous n'avez pas le droit de modifier cette consultation.", $infos_jwt, $result);

        $this->validateDate($data['date_consult'], 'sup');

        $data['date_consult'] = $this->convertDateToMysql($data['date_consult']);

        if (!in_array($data["duree_consult"], [15, 30, 45, 60])) {
            $this->deliverResponse('error', 400, '[R400 REST API] : La durée de la consultation doit être 15, 30, 45 ou 60 minutes');
        }
        $this->checkMedecinAvailable($data);

        $keys = implode(' = ?, ',array_keys($data));
        $sql = 'UPDATE consultation SET ' . $keys . ' = ? WHERE id_consult = ?';
        $finalData = array_merge(array_values($data), [$id]);
        $result = $this->updateDelete($sql, $finalData);
        if($result){
            $result = $this->selectFirst("SELECT * FROM consultation WHERE id_consult = ?", [$id]);
            $this->deliverResponse('success', 201, '[R201 REST API] : Consultation modifiée', $result);
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Echec de la modification de la consultation');
        }
    }

    /**
     * This function is used to handle the DELETE request
     *
     * @param int $id Id of the consultation
     */
    public function deleteRequest(int $id): void
    {
        $infos_jwt = $this->jwtu->checkRole(["administrateur", "secretaire", "medecin", "usager"]);
        $result = $this->checkConsultationExists($id);

        
        $this->checkRight("medecin", "[R403 REST API] : Vous n'avez pas le droit de supprimer cette consultation.", $infos_jwt, $result);
        
        $this->checkRight("usager", "[R403 REST API] : Vous n'avez pas le droit de supprimer cette consultation.", $infos_jwt, $result);

        $result = $this->updateDelete("DELETE FROM consultation WHERE id_consult = ?", [$id]);
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Consultation supprimée');
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Echec de la suppression de la consultation');
        }
    }

    /**
     * This function is used to check if a consultation exists
     *
     * @param int $id Id of the consultation
     * @return array|null Returns the data of the consultation if it exists, false otherwise
     */
    private function checkConsultationExists(int $id): array|null 
    {
        $sql = "SELECT * FROM consultation WHERE id_consult = ?";
        $result = $this->selectFirst($sql, [$id]);
        if ($result) {
            return $result;
        } else {
            $this->deliverResponse('error', 404, "[R404 REST API] : Aucune consultation avec l'id $id n'a été trouvée");
            return null;
        }
    }


    /**
     * This function is used to check if a medecin is available
     * 
     * @param array $data Data of the consultation
     * @return bool|null Returns true if the medecin is available, delivers an error message otherwise
     */
    private function checkMedecinAvailable(array $data): bool|null
    {
        $id_medecin = $data['id_medecin'];
        $date = $data['date_consult'];
        $heure = $data['heure_consult'];
        $duree = $data['duree_consult'];
        
        $sql = "SELECT * FROM consultation WHERE id_medecin = ? AND date_consult = ?";
        $consultations = $this->selectAll($sql, [$id_medecin, $date]);
        
        $heure = strtotime($heure);
        $heure_fin = $heure + $duree * 60;

        foreach ($consultations as $consultation) {
            $heure_consult = strtotime($consultation['heure_consult']);
            $heure_consult_fin = $heure_consult + $consultation['duree_consult'] * 60;

            if (($heure >= $heure_consult && $heure < $heure_consult_fin) || ($heure_fin > $heure_consult && $heure_fin <= $heure_consult_fin)) {
                $this->deliverResponse('error', 400, '[R400 REST API] : Le médecin n\'est pas disponible à cette date et heure');
            }
        }
        return true;
    }


    /**
     * This function is used to check if a given role has the right to access the data
     *
     * @param string $role The role of the user
     * @param string $error_message The error message to deliver if the user doesn't have the right
     * @param array $infos_jwt Infos of the user's JWT
     * @param array $result Infos of the consultation
     * @return void
     */
    private function checkRight(string $role, string $error_message, array $infos_jwt, array $result) : void
    {
        if ($infos_jwt["role"] == $role) {
            $sql = "SELECT * FROM ".$role." WHERE login = ?";
            $usager = $this->selectFirst($sql, [$infos_jwt["login"]]);
            if ($result["id_".$role] != $usager["id_".$role]) {
                $this->deliverResponse('error', 403, $error_message);
            }
        }
    }
}