<?php 

class Preferences {
    private $table = 'preferencias_usuario';
    private $conection;

    public function __construct() {}

    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }

    /* Obtener preferencias del usuario */
    public function getUserPreferences($user_id){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->table." WHERE usuario_id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();
        
        if(!$result){
            // Crear preferencias por defecto
            return $this->createDefaultPreferences($user_id);
        }
        
        return $result;
    }

    /* Crear preferencias por defecto */
    private function createDefaultPreferences($user_id){
        $this->getConection();
        $defaults = array(
            'tema' => 'light',
            'idioma' => 'es',
            'vista_catalogo' => 'grid',
            'items_por_pagina' => 12,
            'notificaciones' => 1,
            'sonido' => 0
        );
        
        $sql = "INSERT INTO ".$this->table." 
                (usuario_id, tema, idioma, vista_catalogo, items_por_pagina, notificaciones, sonido) 
                VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([
            $user_id,
            $defaults['tema'],
            $defaults['idioma'],
            $defaults['vista_catalogo'],
            $defaults['items_por_pagina'],
            $defaults['notificaciones'],
            $defaults['sonido']
        ]);
        
        $defaults['id'] = $this->conection->lastInsertId();
        $defaults['usuario_id'] = $user_id;
        
        return $defaults;
    }

    /* Actualizar preferencias */
    public function updatePreferences($user_id, $preferences){
        $this->getConection();
        
        // Verificar si existen preferencias
        $current = $this->getUserPreferences($user_id);
        
        $sql = "UPDATE ".$this->table." SET 
                tema = ?,
                idioma = ?,
                vista_catalogo = ?,
                items_por_pagina = ?,
                notificaciones = ?,
                sonido = ?
                WHERE usuario_id = ?";
        
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([
            $preferences['tema'] ?? $current['tema'],
            $preferences['idioma'] ?? $current['idioma'],
            $preferences['vista_catalogo'] ?? $current['vista_catalogo'],
            $preferences['items_por_pagina'] ?? $current['items_por_pagina'],
            $preferences['notificaciones'] ?? $current['notificaciones'],
            $preferences['sonido'] ?? $current['sonido'],
            $user_id
        ]);
    }

    /* Obtener tema del usuario */
    public function getUserTheme($user_id){
        $prefs = $this->getUserPreferences($user_id);
        return $prefs['tema'] ?? 'light';
    }
}

?>