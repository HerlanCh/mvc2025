<?php 

require_once 'model/auth.php';

class authController{
    public $page_title;
    public $view;

    public function __construct() {
        $this->view = 'login';
        $this->page_title = 'Iniciar Sesión';
        $this->authObj = new Auth();
        
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    /* Mostrar formulario de login */
    public function login(){
        $this->page_title = 'Iniciar Sesión';
        $this->view = 'login';
        
        // Si ya está logueado, redirigir
        if(isset($_SESSION['user_id'])){
            header('Location: ?controller=dashboard&action=index');
            exit();
        }
        
        return null;
    }

    /* Procesar login */
    public function processLogin(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            $user = $this->authObj->login($email, $password);
            
            if($user){
                // Crear sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['rol'];
                $_SESSION['login_time'] = time();
                
                // Crear cookie segura si "Recordarme" está marcado
                if($remember){
                    $token = bin2hex(random_bytes(32));
                    $expiry = time() + (30 * 24 * 60 * 60); // 30 días
                    
                    setcookie(
                        'remember_token',
                        $token,
                        array(
                            'expires' => $expiry,
                            'path' => '/',
                            'secure' => false, // Cambiar a true en producción con HTTPS
                            'httponly' => true,
                            'samesite' => 'Strict'
                        )
                    );
                    
                    setcookie(
                        'user_id',
                        $user['id'],
                        array(
                            'expires' => $expiry,
                            'path' => '/',
                            'secure' => false,
                            'httponly' => true,
                            'samesite' => 'Strict'
                        )
                    );
                }
                
                header('Location: ?controller=dashboard&action=index');
                exit();
            } else {
                $_SESSION['login_error'] = 'Email o contraseña incorrectos';
                header('Location: ?controller=auth&action=login');
                exit();
            }
        }
    }

    /* Cerrar sesión */
    public function logout(){
        // Limpiar sesión
        session_unset();
        session_destroy();
        
        // Limpiar cookies
        if(isset($_COOKIE['remember_token'])){
            setcookie('remember_token', '', time() - 3600, '/');
            setcookie('user_id', '', time() - 3600, '/');
        }
        
        header('Location: ?controller=auth&action=login');
        exit();
    }

    /* Registro de usuario */
    public function register(){
        $this->page_title = 'Registrarse';
        $this->view = 'register';
        return null;
    }

    /* Procesar registro */
    public function processRegister(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $result = $this->authObj->register($_POST);
            
            if($result['success']){
                $_SESSION['register_success'] = true;
                header('Location: ?controller=auth&action=login');
            } else {
                $_SESSION['register_error'] = $result['message'];
                header('Location: ?controller=auth&action=register');
            }
            exit();
        }
    }

    /* Verificar autenticación */
    public static function checkAuth(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        
        if(!isset($_SESSION['user_id'])){
            // Verificar cookie de recordarme
            if(isset($_COOKIE['remember_token']) && isset($_COOKIE['user_id'])){
                $authObj = new Auth();
                $user = $authObj->getUserById($_COOKIE['user_id']);
                
                if($user){
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['nombre'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['rol'];
                    return true;
                }
            }
            
            header('Location: ?controller=auth&action=login');
            exit();
        }
        
        return true;
    }

    /* Verificar permisos de rol */
    public static function checkRole($required_role = 'vendedor'){
        self::checkAuth();
        
        $authObj = new Auth();
        if(!$authObj->checkPermission($_SESSION['user_id'], $required_role)){
            header('Location: ?controller=dashboard&action=index&error=permission_denied');
            exit();
        }
    }
}

?>