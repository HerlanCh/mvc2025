<?php 

class Db {
    public $conection;

    public function __construct() {
        try {
            $connectionString = "mysql:host=".DB_HOST.";dbname=".DB.";charset=utf8";
            $this->conection = new PDO($connectionString, DB_USER, DB_PASS);
            $this->conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

?>