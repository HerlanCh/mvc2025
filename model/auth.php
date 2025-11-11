<?php 

class Auth {
    private $table = 'usuario';
    private $conection;

    public function __construct() {}

    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }

    /* Validar login */
    public function login($email, $password){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." WHERE email = ? AND activo = 1";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])){
            // Actualizar último acceso
            $this->updateLastAccess($user['id']);
            return $user;
        }
        
        return false;
    }

    /* Registrar usuario */
    public function register($data){
        $this->getConection();
        
        // Verificar si el email ya existe
        if($this->getUserByEmail($data['email'])){
            return array('success' => false, 'message' => 'El email ya está registrado');
        }
        
        $sql = "INSERT INTO ".$this->table." (nombre, email, password, rol, activo) 
                VALUES(?, ?, ?, ?, 1)";
        $stmt = $this->conection->prepare($sql);
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $rol = isset($data['rol']) ? $data['rol'] : 'vendedor';
        
        try {
            $stmt->execute([
                $data['nombre'],
                $data['email'],
                $hashedPassword,
                $rol
            ]);
            return array('success' => true, 'id' => $this->conection->lastInsertId());
        } catch(Exception $e){
            return array('success' => false, 'message' => 'Error al registrar usuario');
        }
    }

    /* Obtener usuario por email */
    public function getUserByEmail($email){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." WHERE email = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /* Obtener usuario por ID */
    public function getUserById($id){
        $this->getConection();
        $sql = "SELECT id, nombre, email, rol, ultimo_acceso FROM ".$this->table." WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /* Actualizar último acceso */
    private function updateLastAccess($user_id){
        $this->getConection();
        $sql = "UPDATE ".$this->table." SET ultimo_acceso = NOW() WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$user_id]);
    }

    /* Cambiar contraseña */
    public function changePassword($user_id, $old_password, $new_password){
        $user = $this->getUserById($user_id);
        if(!$user) return false;
        
        $this->getConection();
        $sql = "SELECT password FROM ".$this->table." WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$user_id]);
        $current = $stmt->fetch();
        
        if(!password_verify($old_password, $current['password'])){
            return false;
        }
        
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE ".$this->table." SET password = ? WHERE id = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$hashedPassword, $user_id]);
    }

    /* Obtener todos los usuarios  */
    public function getAllUsers(){
        $this->getConection();
        $sql = "SELECT id, nombre, email, rol, activo, ultimo_acceso, fecha_registro 
                FROM ".$this->table." 
                ORDER BY fecha_registro DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* Verificar permisos */
    public function checkPermission($user_id, $required_role = 'vendedor'){
        $user = $this->getUserById($user_id);
        if(!$user) return false;
        
        $roles = array('vendedor' => 1, 'admin' => 2);
        return $roles[$user['rol']] >= $roles[$required_role];
    }
}

?>