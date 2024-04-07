<?php

$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir . '/classes/ConnexionDB.php';

/**
 * AppAPI
 *
 * This class is used to handle the OPTIONS request and deliver the response to the client
 * It extends the ConnexionDB class to have access to the database
 *
 * @category API
 * @author FruitPassion
 */
class AppAPI extends ConnexionDB
{

    private array $allowedOptions;
    private array $infos;

    /**
     * Constructor
     *
     * @param array $allowedOptions Array of allowed options
     */
    public function __construct(array $allowedOptions, array $infos = []){
        parent::__construct();
        $this->allowedOptions = $allowedOptions;
        $this->infos = $infos;
    }

    /**
     * This function is used to get infos
     * 
     * @return array Array of infos
    **/
    protected function getInfos(): array
    {
        return $this->infos;
    }

    /**
     * This function is used to handle the OPTIONS request
     */
    public function optionRequest(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Authorization, Accept");
        header("Access-Control-Allow-Methods: " . implode(', ', $this->allowedOptions));
        http_response_code(204);
    }

    /**
    * This function is used to deliver the response to the client after the request has been processed
    *
    * @param string $status Status of the request, either success or error
    * @param int $status_code HTTP status code
    * @param string $status_message Message to be sent to the client
    * @param array|null $data Data to be sent to the client, null if there is no data to be sent
    * @return void Nothing is returned instead the response is sent to the client in a JSON format
    */
    public function deliverResponse($status, $status_code, $status_message, $data = null): void
    {

        http_response_code($status_code);

        header("HTTP/1.1 $status_code $status_message");

        header("Content-Type:application/json; charset=utf-8");

        header("Access-Control-Allow-Origin: *");
        $response['status'] = $status;
        $response['status_code'] = $status_code;
        $response['status_message'] = $status_message;
        if ($data){
            $response['data'] = $data;
        }

        $json_response = json_encode($response);

        if ($json_response === false) {
            die('json encode ERROR : ' . json_last_error_msg());
        }

        echo $json_response;
        die();
    }

    /**
     * This function is used to check if the arguments are not empty
     *
     * @param array $args Array of arguments
     */
    public function checkArguments($args): void
    {
        if (empty($args)) {
            $this->deliverResponse('error', 400, '[R400 REST API] : Aucun argument n\'a été fourni');
        }
    }

    /**
     * This function is used to check if the argument is an integer
     *
     * @param mixed $arg Argument to be checked
     */
    public function checkArgumentIsInt($arg): void
    {
        if ((!is_numeric($arg)) || ($arg < 1)) {
            $this->deliverResponse('error', 400, '[R400 REST] : L\'identifiant doit être un entier positif non null');
            die();
        } elseif ($arg > 2147483647) {
            $this->deliverResponse('error', 400, '[R400 REST] : L\'identifiant doit être un entier inférieur à 2147483647');
            die();
        }
    }


    /**
     * This function is used to check if the argument is a string
     * 
     * @param mixed $arg Argument to be checked
     */
    public function checkArgumentIsString($arg): void
    {
        if (!is_string($arg)) {
            $this->deliverResponse('error', 400, '[R400 REST] : L\'argument doit être une chaine de caractère');
            die();
        }
    }


    /**
     * This function is used to validate if the date is superior or inferior to the current date
     *
     * @param string $date Date to be validated
     * @param string $sup_inf String to indicate if the date should be superior or inferior to the current date, either 'sup' or 'inf'
     * @return bool Returns true if the date is valid, false otherwise
     */
    protected function validateDate(string $date, string $sup_inf): bool
    {
        if ($sup_inf !== 'sup' && $sup_inf !== 'inf') {
            throw new Exception("Le paramètre sup_inf doit être soit 'sup' soit 'inf'");
        }
        $currentDate = date('d/m/y');
        switch ($sup_inf) {
            case 'sup':
                if ($date < $currentDate) {
                    return true;
                } else {
                    $this->deliverResponse('error', 400, '[R400 REST API] : La date ' . $date . ' est invalide car elle est inferieure à la date actuelle');
                }
            case 'inf':
                if ($date > $currentDate) {
                    return true;
                } else {
                    $this->deliverResponse('error', 400, '[R400 REST API] : La date ' . $date . ' est invalide car elle est supérieure à la date actuelle');
                }
            default:
                return false;
        }
    }

    /**
     * This function is used to check if a medecin exists in the database
     *
     * @param int $id Id of the medecin
     * @return array|null Returns the data of the medecin if it exists, delivers an error message otherwise
     */
    protected function checkMedecinExists(int $id): array|null
    {
        $sql = "SELECT * FROM medecin WHERE id_medecin = ?";
        $result = $this->selectFirst($sql, [$id]);
        if ($result) {
            return $result;
        } else {
            $this->deliverResponse('error', 404, "[R404 REST API] : Aucun Medecin avec l'id $id n'a été trouvé");
            return null;
        }
    }

    /**
     * This function is used to check if an usager exists
     *
     * @param int $id Id of the usager
     * @return array|null Returns the data of the usager if it exists, delivers an error message otherwise
     */
    protected function checkUsagerExists(int $id): array|null
    {
        $sql = "SELECT * FROM usager WHERE id_usager = ?";
        $result = $this->selectFirst($sql, [$id]);
        if ($result) {
            return $result;
        } else {
            $this->deliverResponse('error', 404, "[R404 REST API] : Aucun usager avec l'id $id n'a été trouvé");
            return null;
        }
    }

    /**
     * This function is used to check if the civilite is valid
     *
     * @param string $civilite Civilite to be checked
     */
    protected function checkCivilite(string $civilite): void
    {
        if ($civilite !== 'M.' && $civilite !== 'Mme.') {
            $this->deliverResponse('error', 400, "[R400 REST API] : La civilité doit être soit 'M.' soit 'Mme.'");
        }
    }

    /**
     * For a set of data, check if all $neededData value are in $data keys
     *
     * @param array $data Data to be checked
     * @param array $neededData Array of needed data
     * @return void Nothing is returned instead the response is sent to the client in a JSON format
     */
    protected function checkNeededData(array $data, array $neededData): void
    {
        foreach ($neededData as $value) {
            if (!array_key_exists($value, $data)) {
                $this->deliverResponse('error', 400, "[R400 REST API] : Le champ $value est requis");
            }
        }
    }

    /**
     * For a set of data, check if all $allowedData keys are in $data keys
     *
     * @param array $data Data to be checked
     * @param array $allowedData Array of allowed data
     * @return void Nothing is returned instead the response is sent to the client in a JSON format
     */
    protected function checkAllowedData(array $data, array $allowedData): void
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $allowedData)) {
                $this->deliverResponse('error', 400, "[R400 REST API] : Le champ $key n'est pas autorisé");
            }
        }
    }

    /**
     * This function is used to convert a date to the mysql format
     *
     * @param string $date Date to be converted
     * @return string Returns the date in the mysql format
     */
    protected function convertDateToMysql($date): string
    {
        return date('Y-m-d', strtotime($date));
    }


    public function generateLogin($data, $prefix) {
        $civility = $data["civilite"];
        $lastname = $this->convertAccents($data["nom"]);
        $firstname = $this->convertAccents($data["prenom"]);
        $lastname = strtoupper(substr($lastname, 0, 2));
        $firstname = strtoupper(substr($firstname, 0, 2));
        $name_length = strlen($data["nom"]);
        $firstname_length = strlen($data["prenom"]);
        $civility_length = strlen($civility);
        $sum = ($name_length + $firstname_length + $civility_length) * $name_length;
        $login_number = $sum % 100;
    
        if ($civility === 'M.') {
            $civ = 'MO';
        } elseif ($civility === 'Mme.') {
            $civ = 'MA';
        }
    
        return $prefix . $civ . $lastname . $firstname . $login_number;
    }

    private function convertAccents($str) : string
    {
        $unwanted_array = array(    
            'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        return strtr( $str, $unwanted_array );
    }
}
