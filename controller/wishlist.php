<?php 

require_once 'model/wishlist.php';
require_once 'model/balon.php';

class wishlistController{
    public $page_title;
    public $view;

    public function __construct() {
        $this->view = 'wishlist';
        $this->page_title = 'Mis Favoritos';
        $this->wishlistObj = new Wishlist();
        $this->balonObj = new Balon();
        
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        
        // Verificar autenticación
        if(!isset($_SESSION['user_id'])){
            header('Location: ?controller=auth&action=login');
            exit();
        }
    }

    /* Mostrar favoritos */
    public function index(){
        $this->page_title = 'Mis Favoritos';
        $this->view = 'wishlist';
        return $this->wishlistObj->getUserWishlist($_SESSION['user_id']);
    }

    /* Agregar a favoritos */
    public function add(){
        if(isset($_GET['balon_id'])){
            $balon_id = $_GET['balon_id'];
            $result = $this->wishlistObj->addToWishlist($_SESSION['user_id'], $balon_id);
            
            if($result['success']){
                $_GET['response'] = 'added';
            } else {
                $_GET['response'] = 'exists';
            }
        }
        
        // Redirigir de vuelta
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'wishlist';
        header("Location: ?controller={$redirect}&action=index&wishlist_response=" . $_GET['response']);
        exit();
    }

    /* Eliminar de favoritos */
    public function remove(){
        if(isset($_GET['balon_id'])){
            $balon_id = $_GET['balon_id'];
            $this->wishlistObj->removeFromWishlist($_SESSION['user_id'], $balon_id);
            $_GET['response'] = 'removed';
        }
        
        header("Location: ?controller=wishlist&action=index&response=" . $_GET['response']);
        exit();
    }

    /* Limpiar todos los favoritos */
    public function clear(){
        $this->wishlistObj->clearWishlist($_SESSION['user_id']);
        header("Location: ?controller=wishlist&action=index&response=cleared");
        exit();
    }

    /* Agregar al carrito desde favoritos */
    public function addToCart(){
        if(isset($_GET['balon_id'])){
            $balon_id = $_GET['balon_id'];
            $balon = $this->balonObj->getBalonById($balon_id);
            
            if($balon && $balon['stock'] > 0){
                // Inicializar carrito si no existe
                if(!isset($_SESSION['carrito'])){
                    $_SESSION['carrito'] = array();
                }
                
                // Agregar al carrito
                $found = false;
                foreach($_SESSION['carrito'] as &$item){
                    if($item['id'] == $balon_id){
                        $item['cantidad'] += 1;
                        $item['subtotal'] = $item['cantidad'] * $item['precio'];
                        $found = true;
                        break;
                    }
                }
                
                if(!$found){
                    $_SESSION['carrito'][] = array(
                        'id' => $balon['id'],
                        'nombre' => $balon['nombre'],
                        'marca' => $balon['marca'],
                        'precio' => $balon['precio'],
                        'imagen' => $balon['imagen'],
                        'stock_disponible' => $balon['stock'],
                        'cantidad' => 1,
                        'subtotal' => $balon['precio']
                    );
                }
                
                $_GET['response'] = 'added_to_cart';
            } else {
                $_GET['response'] = 'no_stock';
            }
        }
        
        header("Location: ?controller=wishlist&action=index&response=" . $_GET['response']);
        exit();
    }
}

?>