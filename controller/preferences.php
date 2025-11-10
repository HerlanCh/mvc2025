<?php 

require_once 'model/preferences.php';

class preferencesController{
    public $page_title;
    public $view;

    public function __construct() {
        $this->view = 'preferences';
        $this->page_title = 'Preferencias';
        $this->preferencesObj = new Preferences();
        
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        
        // Verificar autenticación
        if(!isset($_SESSION['user_id'])){
            header('Location: ?controller=auth&action=login');
            exit();
        }
    }

    /* Mostrar preferencias */
    public function index(){
        $this->page_title = 'Mis Preferencias';
        $this->view = 'preferences';
        return $this->preferencesObj->getUserPreferences($_SESSION['user_id']);
    }

    /* Guardar preferencias */
    public function save(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $preferences = array(
                'tema' => $_POST['tema'] ?? 'light',
                'idioma' => $_POST['idioma'] ?? 'es',
                'vista_catalogo' => $_POST['vista_catalogo'] ?? 'grid',
                'items_por_pagina' => intval($_POST['items_por_pagina'] ?? 12),
                'notificaciones' => isset($_POST['notificaciones']) ? 1 : 0,
                'sonido' => isset($_POST['sonido']) ? 1 : 0
            );
            
            $result = $this->preferencesObj->updatePreferences($_SESSION['user_id'], $preferences);
            
            if($result){
                $_GET['response'] = 'success';
            } else {
                $_GET['response'] = 'error';
            }
        }
        
        return $this->preferencesObj->getUserPreferences($_SESSION['user_id']);
    }

    /* Guardar solo el tema (AJAX) */
    public function saveTheme(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $tema = $_POST['tema'] ?? 'light';
            
            // Validar tema
            if(!in_array($tema, ['light', 'dark'])){
                $tema = 'light';
            }
            
            // Obtener preferencias actuales
            $currentPrefs = $this->preferencesObj->getUserPreferences($_SESSION['user_id']);
            
            // Actualizar solo el tema
            $preferences = array(
                'tema' => $tema,
                'idioma' => $currentPrefs['idioma'],
                'vista_catalogo' => $currentPrefs['vista_catalogo'],
                'items_por_pagina' => $currentPrefs['items_por_pagina'],
                'notificaciones' => $currentPrefs['notificaciones'],
                'sonido' => $currentPrefs['sonido']
            );
            
            $this->preferencesObj->updatePreferences($_SESSION['user_id'], $preferences);
            
            // Retornar JSON si es AJAX
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit();
            }
            
            return null;
        }
    }

    /* Restablecer a valores por defecto */
    public function reset(){
        $defaults = array(
            'tema' => 'light',
            'idioma' => 'es',
            'vista_catalogo' => 'grid',
            'items_por_pagina' => 12,
            'notificaciones' => 1,
            'sonido' => 0
        );
        
        $this->preferencesObj->updatePreferences($_SESSION['user_id'], $defaults);
        header('Location: ?controller=preferences&action=index&response=reset');
        exit();
    }
}

?>