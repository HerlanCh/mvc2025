<?php 

class Ball {

    private $table = 'balls';
    private $conection;

    public function __construct() {
        
    }

    /* Set conection */
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }

    /* Get all balls */
    public function getBalls(){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." ORDER BY created_at DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /* Get ball by id */
    public function getBallById($id){
        if(is_null($id)) return false;
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table. " WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    /* Save ball */
    public function save($param){
        $this->getConection();

        $name = $description = $price = $brand = $category = $stock = $image = "";
        $exists = false;

        if(isset($param["id"]) and $param["id"] !=''){
            $actualBall = $this->getBallById($param["id"]);
            if(isset($actualBall["id"])){
                $exists = true;    
                $id = $param["id"];
                $name = $actualBall["name"];
                $description = $actualBall["description"];
                $price = $actualBall["price"];
                $brand = $actualBall["brand"];
                $category = $actualBall["category"];
                $stock = $actualBall["stock"];
                $image = $actualBall["image"];
            }
        }

        // Received values
        if(isset($param["name"])) $name = $param["name"];
        if(isset($param["description"])) $description = $param["description"];
        if(isset($param["price"])) $price = $param["price"];
        if(isset($param["brand"])) $brand = $param["brand"];
        if(isset($param["category"])) $category = $param["category"];
        if(isset($param["stock"])) $stock = $param["stock"];
        if(isset($param["image"])) $image = $param["image"];

        if($exists){
            $sql = "UPDATE ".$this->table. " SET name=?, description=?, price=?, brand=?, category=?, stock=?, image=? WHERE id=?";
            $stmt = $this->conection->prepare($sql);
            $res = $stmt->execute([$name, $description, $price, $brand, $category, $stock, $image, $id]);
        }else{
            $sql = "INSERT INTO ".$this->table. " (name, description, price, brand, category, stock, image) values(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$name, $description, $price, $brand, $category, $stock, $image]);
            $id = $this->conection->lastInsertId();
        }    

        return $id;    
    }

    /* Delete ball by id */
    public function deleteBallById($id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->table. " WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }

}

?>