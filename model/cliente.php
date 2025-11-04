<?php 

class Cliente {
    private $table = 'cliente';
    private $conection;

    public function __construct() {}

    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }

    /* Get all clientes */
    public function getClientes(){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." ORDER BY id DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* Get cliente by id */
    public function getClienteById($id){
        if(is_null($id)) return false;
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /* Get cliente by email */
    public function getClienteByEmail($email){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." WHERE email = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /* Save cliente */
    public function save($param){
        $this->getConection();

        $nombre = $apellido = $email = $telefono = $direccion = $ciudad = "";

        $exists = false;
        if(isset($param["id"]) && $param["id"] != ''){
            $actualCliente = $this->getClienteById($param["id"]);
            if(isset($actualCliente["id"])){
                $exists = true;
                $id = $param["id"];
                $nombre = $actualCliente["nombre"];
                $apellido = $actualCliente["apellido"];
                $email = $actualCliente["email"];
                $telefono = $actualCliente["telefono"];
                $direccion = $actualCliente["direccion"];
                $ciudad = $actualCliente["ciudad"];
            }
        }

        if(isset($param["nombre"])) $nombre = $param["nombre"];
        if(isset($param["apellido"])) $apellido = $param["apellido"];
        if(isset($param["email"])) $email = $param["email"];
        if(isset($param["telefono"])) $telefono = $param["telefono"];
        if(isset($param["direccion"])) $direccion = $param["direccion"];
        if(isset($param["ciudad"])) $ciudad = $param["ciudad"];

        if($exists){
            $sql = "UPDATE ".$this->table." SET nombre=?, apellido=?, email=?, telefono=?, direccion=?, ciudad=? WHERE id=?";
            $stmt = $this->conection->prepare($sql);
            $res = $stmt->execute([$nombre, $apellido, $email, $telefono, $direccion, $ciudad, $id]);
        } else {
            $sql = "INSERT INTO ".$this->table." (nombre, apellido, email, telefono, direccion, ciudad) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$nombre, $apellido, $email, $telefono, $direccion, $ciudad]);
            $id = $this->conection->lastInsertId();
        }

        return $id;
    }

    /* Delete cliente */
    public function deleteClienteById($id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->table." WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }

    /* Get total clientes */
    public function getTotalClientes(){
        $this->getConection();
        $sql = "SELECT COUNT(*) as total FROM ".$this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
}

?>