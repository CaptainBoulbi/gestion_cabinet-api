<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/AppAPI.php';

/**
 * UsagerAPI
 * 
 * This class is used to handle the GET, POST, PATCH, DELETE and OPTIONS request for the usager table
 * 
 * @category API
 * @author FruitPassion
 */
class UsagerAPI extends AppAPI{

    /**
     * Constructor
     * 
     * This constructor is used to call the parent constructor and pass the allowed options to the parent constructor
     * 
     * @param array $allowedOptions Allowed options for the API
     */
    public function __construct(array $allowedOptions){
        parent::__construct($allowedOptions);
    }

    /**
     * This function is used to handle the GET request
     */
    public function getRequest(): void
    {
        $sql = "SELECT * FROM usager";
        $result = $this->selectAll($sql);
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Usagers trouvés', $result);
        }else{
            $this->deliverResponse('error', 404, '[R404 REST API] : Aucun usager trouvé');
        }
    }

    /**
     * This function is used to handle the GET request by id
     * 
     * @param int $id Id of the usager
     */
    public function getRequestById(int $id): void
    {
        $sql = "SELECT * FROM usager WHERE id_usager = ?";
        $data = [$id];
        $result = $this->selectFirst($sql, $data);
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Usager trouvé', $result);
        }else{
            $this->deliverResponse('error', 404, "[R404 REST API] : Aucun usager avec l'id $id n'a été trouvé");
        }
    }

    /**
     * This function is used to handle the POST request
     */
    public function postRequest(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $sql = "SELECT * FROM medecin WHERE id_medecin = ?";
        $result = $this->selectFirst($sql, [$data['id_usager']]);
        if(!$result){
            $this->deliverResponse('error', 404, "[R404 REST API] : Aucun usager avec l'id {$data['id_usager']} n'a été trouvé");
        }

        if(!$this->validateDate($data['date_nais'])){
            $this->deliverResponse('error', 400, '[R400 REST API] : La date de naissance n\'est pas valide');
        }

        $sql = "INSERT INTO usager (civilite, nom, prenom, sexe, adresse, code_postal, ville, date_nais, lieu_nais, num_secu, id_medecin) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $result = $this->insert($sql, [
            $data['civilite'],
            $data['nom'],
            $data['prenom'],
            $data['sexe'],
            $data['adresse'],
            $data['code_postal'],
            $data['ville'],
            $this->convertDateToMysql($data['date_nais']),
            $data['lieu_nais'],
            $data['num_secu'],
            $data['id_medecin']
        ]);

        if($result){
            $sql = "SELECT * FROM usager WHERE id_usager = ?";
            $result = $this->selectFirst($sql, [$result]);
            $this->deliverResponse('success', 201, '[R201 REST API] : Usager inséré en base de donnée avec succès', $result);
        }else{
            $this->deliverResponse('error', 400, "[R400 REST API] : Erreur lors de l'insertion de l'usager en base de donnée");
        }
    }

    /**
     * This function is used to handle the PATCH request
     * 
     * @param int $id Id of the usager
     */
    public function patchRequest(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $keys = implode(' = ?, ',array_keys($data));
        $sql = "UPDATE usager SET $keys = ? WHERE id_usager = ?";
        $finalData = array_merge(array_values($data), [$id]);
        if($this->updateDelete($sql, $finalData)){
            $this->deliverResponse('success', 200, '[R200 REST API] : Usager mit à jour avec succès');
        }else{
            $this->deliverResponse('error', 400, '[R400 REST API] : Usager non mis à jour');
        }
    }

    /**
     * This function is used to handle the DELETE request
     * 
     * @param int $id Id of the usager
     */
    public function deleteRequest(int $id): void
    {
        $sql = "SELECT * FROM usager WHERE id_usager = ?";
        $data = [$id];
        $result = $this->selectFirst($sql, $data);
        if(!$result){
            $this->deliverResponse('error', 404, "[R404 REST API] : Aucun usager avec l'id $id n'a été trouvé");
        } else {
            $sql = "DELETE FROM consultation WHERE id_usager = ?";
            $result = $this->updateDelete($sql, [$id]);

            $sql = "DELETE FROM usager WHERE id_usager = ?";
            $result = $this->updateDelete($sql, [$id]);
            var_dump($result);
            if($result){
                $this->deliverResponse('success', 200, '[R200 REST API] : Médecin supprimé avec succès');
            }else{
                $this->deliverResponse('error', 400, '[R400 REST API] : Médecins non supprimées');
            }
        }
    }

    /**
     * This function is used to validate the date
     * 
     * @param string $date Date to be validated
     * @return bool Returns true if the date is valid, false otherwise
     */
    private function validateDate(string $date): bool
    {
        $currentDate = new DateTime();
        $date = new DateTime($date);
        return $date < $currentDate;
    }
}
