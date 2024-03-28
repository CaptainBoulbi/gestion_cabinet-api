<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/AuthAPI.php';
require_once $rootDir . '/classes/JWTUtils.php';

/**
 * MedecinAPI
 * 
 * This class is used to handle the GET, POST, PATCH, DELETE and OPTIONS request for the medecin table
 * 
 * @category API
 * @author FruitPassion
 */
class InterractionsAPI extends AuthAPI
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
        parent::__construct($allowedOptions, ['login', 'mdp']);
        $this->jwtu = new JWTUtils();
    }

    /**
     * This function is used to handle the POST request
     * 
     * @param string $role Role of the entity to insert
     * @param array $needed Array of needed roles to insert the entity
     * @return void Nothing is returned instead the response is sent to the client in a JSON format
     */
    public function postRequest(string $role, array $needed): void
    {
        $this->jwtu->checkRole($needed);
        $data = json_decode(file_get_contents('php://input'), true);

        $this->checkNeededData($data, $this->getInfos());

        $sql = 'INSERT INTO user_auth_v2 ('. implode(', ', $this->getInfos()) .', role) VALUE (?, ?, ?)';
        $result = $this->insert($sql, [
            $data['login'],
            password_hash($data['mdp'], PASSWORD_BCRYPT, ["cost" => 8]),
            $role
        ]);

        if($result){
            $this->deliverResponse('success', 201, '[R201 REST API] : Entitée insérée en base de donnée avec succès');
        }else{
            $this->deliverResponse('error', 500, "[R500 REST API] : Erreur lors de l'insertion de l'entitée en base de donnée");
        }
    }

    /**
     * This function is used to handle the DELETE request
     * 
     * @param string $role Role of the entity to delete
     * @param array $needed Array of needed roles to delete the entity
     */
    public function deleteRequest(string $role, array $needed): void
    {
        $infos_jwt = $this->jwtu->checkRole($needed);
        $data = json_decode(file_get_contents('php://input'), true);

        $this->checkNeededData($data, ['login']);

        $info_ent = $this->checkLoginExist($data['login'], $role);
        $isMedecinOrUsager = $infos_jwt["role"] == "medecin" || $infos_jwt["role"] == "usager";
        $isDifferentLogin = $infos_jwt["login"] != $info_ent["login"];

        if ($isMedecinOrUsager && $isDifferentLogin) {
            $this->deliverResponse('error', 403, '[R403 REST API] : Vous n\'avez pas le droit de supprimer cette entitée');
        }

        if($this->updateDelete("DELETE FROM user_auth_v2 WHERE login = ? AND role = ?", [$data['login'], $role])){
            $this->deliverResponse('success', 200, '[R200 REST API] : Entité supprimé avec succès');
        }else{
            $this->deliverResponse('error', 500, '[R500 REST API] : Entité non supprimées');
        }
    }
    
    /**
     * This function is used to chekc if an entity exist in the database
     * 
     * @param string $login Login of the entity
     * @param string $role Role of the entity
     * @return array Data of the entity
     */
    private function checkLoginExist(string $login, string $role): array
    {
        $sql = "SELECT * FROM user_auth_v2 WHERE login = ? AND role = ?";
        $result = $this->selectFirst($sql, [$login, $role]);
        if (!$result) {
            $this->deliverResponse('error', 404, '[R404 REST API] : Entité non trouvé');
        }
        return $result;
    }


    /**
     * For a set of data, check if all $neededData value are in $data keys
     * 
     * @param array $data Data to be checked
     * @param array $neededData Array of needed data
     * @return void Nothing is returned instead the response is sent to the client in a JSON format
     */
    private function checkNeededData(array $data, array $neededData): void
    {
        foreach ($neededData as $value) {
            if (!array_key_exists($value, $data)) {
                $this->deliverResponse('error', 400, "[R400 REST API] : Le champ $value est requis");
            }
        }
    }
}
