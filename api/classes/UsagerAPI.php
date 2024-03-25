<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/AppAPI.php';
require_once $rootDir . '/classes/JWTUtils.php';


/**
 * UsagerAPI
 *
 * This class is used to handle the GET, POST, PATCH, DELETE and OPTIONS request for the usager table
 *
 * @category API
 * @author FruitPassion
 */
class UsagerAPI extends AppAPI
{
    private $jwtu;


    /**
     * Constructor
     *
     * This constructor is used to call the parent constructor and pass the allowed options to the parent constructor
     *
     * @param array $allowedOptions Allowed options for the API
     */
    public function __construct(array $allowedOptions){
        parent::__construct($allowedOptions, ['civilite', 'nom', 'prenom', 'sexe', 'adresse', 'code_postal',
        'ville', 'date_nais', 'lieu_nais', 'num_secu', 'id_medecin']);
        $this->jwtu = new JWTUtils();
    }


    /**
     * This function is used to handle the GET request
     */
    public function getRequest(): void
    {
        $this->jwtu->getAndVerify();
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
        $result = $this->checkUsagerExists($id);
        $this->deliverResponse('success', 200, '[R200 REST API] : Usager trouvé', $result);
    }

    /**
     * This function is used to handle the POST request
     */
    public function postRequest(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $this->checkNeededData($data, $this->getInfos());
        
        $this->checkNumSecuUsed($data['num_secu']);
        $this->validateDate($data['date_nais'], 'inf');
        $this->checkMedecinExists($data['id_medecin']);
        $this->checkCivilite($data['civilite']);
        $this->checkSexe($data['sexe']);

        $sql = 'INSERT INTO usager ('. implode(', ', $this->getInfos()) .') VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

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
            $this->deliverResponse('success', 201, '[R201 REST API] : Usager inséré en base de
            donnée avec succès', $result);
        }else{
            $this->deliverResponse('error', 500, "[R500 REST API] : Erreur lors de l'insertion de l'usager
            en base de donnée");
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

        $this->checkAllowedData($data, $this->getInfos());

        $this->checkUsagerExists($id);
        
        if (isset($data['num_secu'])) {
            $this->checkNumSecuUsed($data['num_secu']);
        }
        if (isset($data['date_nais'])) {
            $this->validateDate($data['date_nais'], 'inf');
        }
        if (isset($data['id_medecin'])) {
            $this->checkMedecinExists($data['id_medecin']);
        }
        if (isset($data['civilite'])) {
            $this->checkCivilite($data['civilite']);
        }
        if (isset($data['sexe'])) {
            $this->checkSexe($data['sexe']);
        }

        $keys = implode(' = ?, ',array_keys($data));
        $sql = "UPDATE usager SET $keys = ? WHERE id_usager = ?";
        $finalData = array_merge(array_values($data), [$id]);
        if($this->updateDelete($sql, $finalData)){
            $this->deliverResponse('success', 201, '[R201 REST API] : Usager mit à jour avec succès');
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Usager non mis à jour');
        }
    }

    /**
     * This function is used to handle the DELETE request
     * 
     * @param int $id Id of the usager
     */
    public function deleteRequest(int $id): void
    {
        $this->checkUsagerExists($id);
        
        $this->updateDelete("DELETE FROM consultation WHERE id_usager = ?", [$id]);

        $sql = "DELETE FROM usager WHERE id_usager = ?";
        if($this->updateDelete($sql, [$id])){
            $this->deliverResponse('success', 200, '[R200 REST API] : Usager supprimé avec succès');
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Usager non supprimé');
        }
    }

    /**
     * This function is used to check if the sexe is valid
     *
     * @param string $sexe Sexe to be checked
     */
    private function checkSexe(string $sexe): void
    {
        if ($sexe !== 'M' && $sexe !== 'F') {
            $this->deliverResponse('error', 400, "[R400 REST API] : Le sexe doit être soit 'M' soit 'F'");
        }
    }

    /**
     * This function is used to check if the num_secu is already used
     *
     * @param int $num Num_secu to be checked
     */
    private function checkNumSecuUsed(int $num): void
    {
        $sql = "SELECT * FROM usager WHERE num_secu = ?";
        $result = $this->selectFirst($sql, [$num]);
        if ($result) {
            $this->deliverResponse('error', 400, "[R400 REST API] : Le numéro de sécurité sociale $num est déjà utilisé");
        }
    }
}
