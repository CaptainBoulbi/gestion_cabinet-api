<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/AppAPI.php';

/**
 * MedecinAPI
 * 
 * This class is used to handle the GET, POST, PATCH, DELETE and OPTIONS request for the medecin table
 * 
 * @category API
 * @author FruitPassion
 */
class MedecinAPI extends AppAPI
{

    /**
     * Constructor
     * 
     * This constructor is used to call the parent constructor and pass the allowed options to the parent constructor
     * 
     * @param array $allowedOptions Allowed options for the API
     */
    public function __construct(array $allowedOptions){
        parent::__construct($allowedOptions, ['civilite', 'nom', 'prenom']);
    }

    /**
     * This function is used to handle the GET request
     */
    public function getRequest(): void
    {
        $sql = "SELECT * FROM medecin";
        $result = $this->selectAll($sql);
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Médecins trouvés', $result);
        }else{
            $this->deliverResponse('error', 404, '[R404 REST API] : Aucun médecin trouvé');
        }
    }

    /**
     * This function is used to handle the GET request by id
     * 
     * @param int $id Id of the medecin
     */
    public function getRequestById(int $id): void
    {
        $result = $this->checkMedecinExists($id);
        $this->deliverResponse('success', 200, '[R200 REST API] : Médecin trouvé', $result);
    }

    /**
     * This function is used to handle the POST request
     */
    public function postRequest(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $this->checkNeededData($data, $this->getInfos());
        
        $this->checkCivilite($data['civilite']);

        $sql = 'INSERT INTO medecin ('. implode(', ', $this->getInfos()) .') VALUE (?, ?, ?)';
        $result = $this->insert($sql, [
            $data['civilite'],
            $data['nom'],
            $data['prenom']
        ]);
        if($result){
            $sql = "SELECT * FROM medecin WHERE id_medecin = ?";
            $result = $this->selectFirst($sql, [$result]);
            $this->deliverResponse('success', 201, '[R201 REST API] : Médecin inséré en base de donnée avec succès', $result);
        }else{
            $this->deliverResponse('error', 500, "[R500 REST API] : Erreur lors de l'insertion du médecin en base de donnée");
        }
    }

    /**
     * This function is used to handle the PATCH request
     * 
     * @param int $id Id of the medecin
     */
    public function patchRequest(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $this->checkAllowedData($data, $this->getInfos());

        $this->checkMedecinExists($id);
        if (isset($data['civilite'])) {
            $this->checkCivilite($data['civilite']);
        }

        $keys = implode(' = ?, ',array_keys($data));
        $sql = "UPDATE medecin SET $keys = ? WHERE id_medecin = ?";
        $finalData = array_merge(array_values($data), [$id]);
        if($this->updateDelete($sql, $finalData)){
            $this->deliverResponse('success', 201, '[R201 REST API] : Médecin mit à jour avec succès');
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Médecin non mises à jour');
        }
    }

    /**
     * This function is used to handle the DELETE request
     * 
     * @param int $id Id of the medecin
     */
    public function deleteRequest(int $id): void
    {
        $this->checkMedecinExists($id);

        $this->updateDelete("DELETE FROM consultation WHERE id_medecin = ?", [$id]);

        $sql = "DELETE FROM medecin WHERE id_medecin = ?";
        if($this->updateDelete($sql, [$id])){
            $this->deliverResponse('success', 200, '[R200 REST API] : Médecin supprimé avec succès');
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Médecins non supprimées');
        }
    }
}
