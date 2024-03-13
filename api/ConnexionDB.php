<?php

class ConnexionDB
{
    private ?PDO $pdo = null;
    private $stmt = null;


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

    
    public function __destruct()
    {
        if ($this->stmt !== null) {
            $this->stmt = null;
        }
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
    }

    protected function selectFirst($sql, $data = null): false|array
    {
        $this->updateDelete($sql, $data);
        return $this->stmt->fetch();
    }

    protected function selectAll($sql, $data = null): false|array
    {
        $this->updateDelete($sql, $data);
        return $this->stmt->fetchAll();
    }

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
}

const DB_HOST = 'localhost';
const DB_USER = 'local_user';
const DB_PASSWORD = 'password';
const DB_NAME = "db_gestion_cabinet_app";
const DB_CHARSET = "utf8mb4";
