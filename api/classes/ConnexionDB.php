<?php

/**
 * ConnexionDB
 * 
 * This class is used to connect to the database and execute queries
 * 
 * @category DB
 * @author FruitPassion
 */
class ConnexionDB
{
    private ?PDO $pdo = null;
    private $stmt = null;

    /**
     * Constructor
     * 
     * This constructor is used to connect to the database
     */
    protected function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
                DB_USER, DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            die();
        }
    }

    /**
     * Destructor
     * 
     * This destructor is used to close the connection to the database
     */
    public function __destruct()
    {
        if ($this->stmt !== null) {
            $this->stmt = null;
        }
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
    }

    /**
     * This function is used to execute a select query and return the first row
     *
     * @param string $sql SQL query
     * @param array|null $data Data to be used in the query
     * @return array|false Returns the first row of the result set as an associative array, or false if there is no result
     */
    protected function selectFirst($sql, $data = null): false|array
    {
        $this->updateDelete($sql, $data);
        return $this->stmt->fetch();
    }

    /**
     * This function is used to execute a select query and return all the rows
     * 
     * @param string $sql SQL query
     * @param array|null $data Data to be used in the query
     * @return false|array Returns an array containing all of the result set rows, or false if there is no result
     */
    protected function selectAll($sql, $data = null): false|array
    {
        $this->updateDelete($sql, $data);
        return $this->stmt->fetchAll();
    }

    /**
     * This function is used to execute an insert query
     *
     * @param string $sql SQL query
     * @param array|null $data Data to be used in the query
     * @return string|bool Returns the last inserted id, or false if the query failed
     */
    protected function insert($sql, $data = null): string|bool
    {
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($data);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * This function is used to execute an update or delete query
     *
     * @param string $sql SQL query
     * @param array|null $data Data to be used in the query
     * @return bool Returns true if the query was successful, otherwise it returns false
     */
    protected function updateDelete($sql, $data = null): bool
    {
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
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
}

const DB_HOST = 'localhost';
const DB_USER = 'local_user';
const DB_PASSWORD = 'password';
const DB_NAME = "db_gestion_cabinet_app";
const DB_CHARSET = "utf8mb4";
