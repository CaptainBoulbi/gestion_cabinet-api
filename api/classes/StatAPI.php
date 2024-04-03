<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/AppAPI.php';
require_once $rootDir . '/classes/JWTUtils.php';

/**
 * StatAPI
 * 
 * This class is used to handle the GET and OPTIONS request for the stat table
 * 
 * @category API
 * @author FruitPassion
 */
class StatAPI extends AppAPI
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
        parent::__construct($allowedOptions);
        $this->jwtu = new JWTUtils();
    }

    /**
     * This function is used to handle the GET request to get the total hours of consultation for each medecin
     */
    public function getRequestMedecin(): void
    {
        $this->jwtu->checkRole(["administrateur", "secretaire", "medecin", "usager", "invite"]);
        $sql = "SELECT m.id_medecin, m.civilite, m.nom, m.prenom ,COALESCE(TIME_FORMAT(SEC_TO_TIME(SUM(c.duree_consult * 60)), '%kh%i'), '00h00') AS heures_consultees FROM medecin m LEFT JOIN  consultation c ON m.id_medecin = c.id_medecin GROUP BY m.id_medecin, m.civilite, m.nom, m.prenom;";
        $result = $this->selectAll($sql);
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Statistiques des médecins récupérées', $result);
        }else{
            $this->deliverResponse('error', 404, '[R404 REST API] : Aucun médecin trouvé');
        }
    }

    /**
     * This function is used to handle the GET request to get general stats about usagers sex and age
     */
    public function getRequestUsagers(): void
    {
        $this->jwtu->checkRole(["administrateur", "secretaire", "medecin", "usager", "invite"]);
        $sql = "SELECT u.id_usager, u.sexe, TIMESTAMPDIFF(YEAR, u.date_nais, CURDATE()) AS age FROM usager u;";
        $result = $this->selectAll($sql);

        $statistiques = [
            "moins25" => [
                "homme" => 0,
                "femme" => 0
            ],
            "entre25et50" => [
                "homme" => 0,
                "femme" => 0
            ],
            "plus50" => [
                "homme" => 0,
                "femme" => 0
            ]
        ];

        foreach ($result as $usager) {
            if ($usager['age'] < 25) {
                if ($usager['sexe'] == "H") {
                    $statistiques["moins25"]["homme"]++;
                } else {
                    $statistiques["moins25"]["femme"]++;
                }
            } elseif ($usager['age'] >= 25 && $usager['age'] <= 50) {
                if ($usager['sexe'] == "H") {
                    $statistiques["entre25et50"]["homme"]++;
                } else {
                    $statistiques["entre25et50"]["femme"]++;
                }
            } else {
                if ($usager['sexe'] == "H") {
                    $statistiques["plus50"]["homme"]++;
                } else {
                    $statistiques["plus50"]["femme"]++;
                }
            }
        }
        if($result){
            $this->deliverResponse('success', 200, '[R200 REST API] : Statistiques des usagers récupérées', $statistiques );
        }else{
            $this->deliverResponse('error', 404, '[R404 REST API] : Aucun usager trouvé');
        }
    }

}
