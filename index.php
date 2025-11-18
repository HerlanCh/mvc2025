<?php 

require_once 'config/config.php';
require_once 'model/db.php';

// Iniciar sesión
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_GET["controller"])) $_GET["controller"] = constant("DEFAULT_CONTROLLER");
if(!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

// Rutas públicas (sin autenticación)
$public_routes = array(
    'auth' => array('login', 'processLogin', 'register', 'processRegister')
);

$controller_path = 'controller/'.$_GET["controller"].'.php';

/* Revisa si el contorlador existe*/
if(!file_exists($controller_path)) $controller_path = 'controller/'.constant("DEFAULT_CONTROLLER").'.php';

/* Caargar controlador*/
require_once $controller_path;
$controllerName = $_GET["controller"].'Controller';

// Verificar si la ruta requiere autenticación
$is_public = isset($public_routes[$_GET["controller"]]) && 
              in_array($_GET["action"], $public_routes[$_GET["controller"]]);

if(!$is_public && $_GET["controller"] !== 'auth'){
    require_once 'controller/auth.php';
    authController::checkAuth();
}

$controller = new $controllerName();

/* Verifica si el metodo existe*/
$dataToView["data"] = array();
if(method_exists($controller,$_GET["action"])) {
    $dataToView["data"] = $controller->{$_GET["action"]}();
}

/* Load views - Solo para vistas con template */
$public_controllers = array('auth', 'login'); // Controladores que no usan template

if(!in_array($_GET["controller"], $public_controllers)){
    require_once 'view/template/header.php';
    require_once 'view/'.$controller->view.'.php';
    require_once 'view/template/footer.php';
} else {
    // Cargar solo la vista sin header/footer
    require_once 'view/'.$controller->view.'.php';
}

?>