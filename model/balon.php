<?php 

class Balon {
    private $table = 'balon';
    private $conection;

    public function __construct() {}

    /* Set connection */
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }

    /* Get all balones */
    public function getBalones(){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." ORDER BY id DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* Get balon by id */
    public function getBalonById($id){
        if(is_null($id)) return false;
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /* Save balon */
    public function save($param){
        $this->getConection();

        /* Set default values */
        $nombre = $marca = $deporte = $imagen = "";
        $precio = $stock = 0;

        /* Check if exists */
        $exists = false;
        if(isset($param["id"]) && $param["id"] != ''){
            $actualBalon = $this->getBalonById($param["id"]);
            if(isset($actualBalon["id"])){
                $exists = true;
                $id = $param["id"];
                $nombre = $actualBalon["nombre"];
                $marca = $actualBalon["marca"];
                $deporte = $actualBalon["deporte"];
                $precio = $actualBalon["precio"];
                $stock = $actualBalon["stock"];
                $imagen = $actualBalon["imagen"];
            }
        }

        /* Received values */
        if(isset($param["nombre"])) $nombre = $param["nombre"];
        if(isset($param["marca"])) $marca = $param["marca"];
        if(isset($param["deporte"])) $deporte = $param["deporte"];
        if(isset($param["precio"])) $precio = $param["precio"];
        if(isset($param["stock"])) $stock = $param["stock"];
        if(isset($param["imagen"])) $imagen = $param["imagen"];

        /* Database operations */
        if($exists){
            $sql = "UPDATE ".$this->table." SET nombre=?, marca=?, deporte=?, precio=?, stock=?, imagen=? WHERE id=?";
            $stmt = $this->conection->prepare($sql);
            $res = $stmt->execute([$nombre, $marca, $deporte, $precio, $stock, $imagen, $id]);
        } else {
            $sql = "INSERT INTO ".$this->table." (nombre, marca, deporte, precio, stock, imagen) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$nombre, $marca, $deporte, $precio, $stock, $imagen]);
            $id = $this->conection->lastInsertId();
        }

        return $id;
    }

    /* Delete balon by id */
    public function deleteBalonById($id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->table." WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>