<?php 

class Wishlist {
    private $table = 'wishlist';
    private $conection;

    public function __construct() {}

    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }

    /* Obtener favoritos del usuario */
    public function getUserWishlist($user_id){
        $this->getConection();
        $sql = "SELECT w.*, b.nombre, b.marca, b.deporte, b.precio, b.stock, b.imagen 
                FROM ".$this->table." w 
                INNER JOIN balon b ON w.balon_id = b.id 
                WHERE w.usuario_id = ? 
                ORDER BY w.fecha_agregado DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    /* Agregar a favoritos */
    public function addToWishlist($user_id, $balon_id){
        // Verificar si ya está en favoritos
        if($this->isInWishlist($user_id, $balon_id)){
            return array('success' => false, 'message' => 'Ya está en favoritos');
        }
        
        $this->getConection();
        $sql = "INSERT INTO ".$this->table." (usuario_id, balon_id) VALUES(?, ?)";
        $stmt = $this->conection->prepare($sql);
        
        try {
            $stmt->execute([$user_id, $balon_id]);
            return array('success' => true, 'message' => 'Agregado a favoritos');
        } catch(Exception $e){
            return array('success' => false, 'message' => 'Error al agregar');
        }
    }

    /* Eliminar de favoritos */
    public function removeFromWishlist($user_id, $balon_id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->table." WHERE usuario_id = ? AND balon_id = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$user_id, $balon_id]);
    }

    /* Verificar si está en favoritos */
    public function isInWishlist($user_id, $balon_id){
        $this->getConection();
        $sql = "SELECT COUNT(*) as count FROM ".$this->table." 
                WHERE usuario_id = ? AND balon_id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$user_id, $balon_id]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    /* Contar favoritos del usuario */
    public function countUserWishlist($user_id){
        $this->getConection();
        $sql = "SELECT COUNT(*) as count FROM ".$this->table." WHERE usuario_id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();
        return $result['count'];
    }

    /* Limpiar favoritos */
    public function clearWishlist($user_id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->table." WHERE usuario_id = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$user_id]);
    }
}

?>