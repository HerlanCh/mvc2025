<?php 

class Db {
    private $host;
    private $db;
    private $user;
    private $password;
    public $conection;

    public function __construct(){
        $this->host = constant('DB_HOST');
        $this->db = constant('DB');
        $this->user = constant('DB_USER');
        $this->password = constant('DB_PASS');
        
        try {
            $this->conection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->password);
            $this->conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

}

?>