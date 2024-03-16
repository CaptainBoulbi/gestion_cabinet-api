<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/AppAPI.php';


/**
 * ConsultationAPI
 *
 * This class is used to manage the consultation of the database
 *
 * @category API
 * @author FruitPassion
 */
class ConsultationAPI extends AppAPI {


    /**
     * Constructor
     *
     * This constructor is used to call the parent constructor and pass the allowed options to the parent constructor
     *
     * @param array $allowedOptions Allowed options for the API
     */
    public function __construct(array $allowedOptions){
        parent::__construct($allowedOptions, ['id_usager', 'id_medecin', 'date_consult', 'heure_consult', 'duree_consult']);
    }

    /**
     * This function is used to handle the GET request
     */
    public function getRequest(): void
    {
        $sql = "SELECT * FROM consultation";
        $result = $this->selectAll($sql);
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
        $result =$this->checkConsultationExists($id);
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Consultation trouvée', $result);
        }
    }

    /**
     * This function is used to handle the POST request
     */
    public function postRequest(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $this->checkNeededData($data, $this->getInfos());

        $this->checkUsagerExists($data['id_usager']);
        $this->checkMedecinExists($data['id_medecin']);
        $this->validateDate($data['date_consult'], 'sup');

        if (!in_array($data["duree_consult"], [15, 30, 45, 60])) {
            $this->deliverResponse('error', 400, '[R400 REST API] : La durée de la consultation doit être 15, 30, 45 ou 60 minutes');
        }

        if (!preg_match('/^(0[8-9]|1[0-7]):[0-5][0-9]$/', $data['heure_consult'])) {
            $this->deliverResponse('error', 400, '[R400 REST API] : L\'heure de la consultation doit être entre 08:00 et 18:00');
        }

        // TODO : check if the medecin is available at the given date and time

        $sql = 'INSERT INTO consultation ('. implode(', ', $this->getInfos()) .') VALUES (?, ?, ?, ?, ?)';
        $id = $this->insert($sql, array_values($data));

        $result = $this->selectFirst("SELECT * FROM consultation WHERE id_consult = ?", [$id]);
        if($result){
            $this->deliverResponse('success', 201, '[R201 REST API] : Consultation ajoutée', $result);
        }else{
            $this->deliverResponse('error', 400, '[R400 REST API] : Echec de l\'ajout de la consultation');
        }
    }


    /**
     * This function is used to handle the PATCH request
     *
     * @param int $id Id of the consultation
     */
    public function patchRequest(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $this->checkAllowedData($data, $this->getInfos());

        $this->checkConsultationExists($id);
        $this->validateDate($data['date_consult'], 'sup');

        if (!in_array($data["duree_consult"], [15, 30, 45, 60])) {
            $this->deliverResponse('error', 400, '[R400 REST API] : La durée de la consultation doit être 15, 30, 45 ou 60 minutes');
        }

        $keys = implode(' = ?, ',array_keys($data));
        $sql = 'UPDATE consultation SET ' . $keys . ' = ? WHERE id_consult = ?';
        $finalData = array_merge(array_values($data), [$id]);
        $result = $this->updateDelete($sql, $finalData);
        if($result){
            $result = $this->selectFirst("SELECT * FROM consultation WHERE id_consult = ?", [$id]);
            $this->deliverResponse('success', 200, '[R200 REST API] : Consultation modifiée', $result);
        }else{
            $this->deliverResponse('error', 400, '[R400 REST API] : Echec de la modification de la consultation');
        }
    }

    /**
     * This function is used to handle the DELETE request
     *
     * @param int $id Id of the consultation
     */
    public function deleteRequest(int $id): void
    {
        $this->checkConsultationExists($id);

        $result = $this->updateDelete("DELETE FROM consultation WHERE id_consult = ?", [$id]);
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Consultation supprimée');
        }else{
            $this->deliverResponse('error', 400, '[R400 REST API] : Echec de la suppression de la consultation');
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

}