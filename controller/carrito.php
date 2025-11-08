<?php 

require_once 'model/balon.php';
require_once 'model/cliente.php';
require_once 'model/venta.php';

class carritoController{
    public $page_title;
    public $view;

    public function __construct() {
        $this->view = 'carrito';
        $this->page_title = 'Carrito de Compras';
        $this->balonObj = new Balon();
        $this->clienteObj = new Cliente();
        $this->ventaObj = new Venta();
        
        // Iniciar sesión si no existe
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        
        // Inicializar carrito
        if(!isset($_SESSION['carrito'])){
            $_SESSION['carrito'] = array();
        }
    }

    /* Ver carrito */
    public function index(){
        $this->page_title = 'Carrito de Compras';
        $this->view = 'carrito';
        return $this->getCarritoItems();
    }

    /* Agregar al carrito */
    public function agregar(){
        if(isset($_POST['balon_id']) && isset($_POST['cantidad'])){
            $balon_id = $_POST['balon_id'];
            $cantidad = intval($_POST['cantidad']);
            
            $balon = $this->balonObj->getBalonById($balon_id);
            
            if($balon && $cantidad > 0){
                // Calcular cantidad ya en carrito
                $cantidad_en_carrito = 0;
                foreach($_SESSION['carrito'] as $item){
                    if($item['id'] == $balon_id){
                        $cantidad_en_carrito = $item['cantidad'];
                        break;
                    }
                }
                
                // Verificar si hay stock suficiente
                $cantidad_total = $cantidad_en_carrito + $cantidad;
                
                if($cantidad_total > $balon['stock']){
                    $_GET["response"] = "insufficient_stock";
                    $_GET["available"] = $balon['stock'];
                    $_GET["in_cart"] = $cantidad_en_carrito;
                } else {
                    // Verificar si ya existe en el carrito
                    $found = false;
                    foreach($_SESSION['carrito'] as &$item){
                        if($item['id'] == $balon_id){
                            $item['cantidad'] += $cantidad;
                            $item['subtotal'] = $item['cantidad'] * $item['precio'];
                            $found = true;
                            break;
                        }
                    }
                    
                    // Si no existe, agregarlo
                    if(!$found){
                        $_SESSION['carrito'][] = array(
                            'id' => $balon['id'],
                            'nombre' => $balon['nombre'],
                            'marca' => $balon['marca'],
                            'precio' => $balon['precio'],
                            'imagen' => $balon['imagen'],
                            'stock_disponible' => $balon['stock'],
                            'cantidad' => $cantidad,
                            'subtotal' => $balon['precio'] * $cantidad
                        );
                    }
                    
                    $_GET["response"] = "added";
                }
            } else {
                $_GET["response"] = "error";
            }
        }
        
        header("Location: ?controller=carrito&action=index");
        exit();
    }

    /* Actualizar cantidad */
    public function actualizar(){
        if(isset($_POST['balon_id']) && isset($_POST['cantidad'])){
            $balon_id = $_POST['balon_id'];
            $cantidad = intval($_POST['cantidad']);
            
            // Obtener stock actual del producto
            $balon = $this->balonObj->getBalonById($balon_id);
            
            if($balon){
                foreach($_SESSION['carrito'] as &$item){
                    if($item['id'] == $balon_id){
                        if($cantidad > 0){
                            // Verificar si hay stock suficiente
                            if($cantidad > $balon['stock']){
                                $_GET["response"] = "insufficient_stock";
                                $_GET["available"] = $balon['stock'];
                                $_GET["product_name"] = $balon['nombre'];
                            } else {
                                $item['cantidad'] = $cantidad;
                                $item['subtotal'] = $item['cantidad'] * $item['precio'];
                                $item['stock_disponible'] = $balon['stock'];
                                $_GET["response"] = "updated";
                            }
                        } else {
                            // Si la cantidad es 0, eliminar del carrito
                            foreach($_SESSION['carrito'] as $key => $cart_item){
                                if($cart_item['id'] == $balon_id){
                                    unset($_SESSION['carrito'][$key]);
                                    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                                    break;
                                }
                            }
                        }
                        break;
                    }
                }
            }
        }
        
        header("Location: ?controller=carrito&action=index");
        exit();
    }

    /* Eliminar del carrito */
    public function eliminar(){
        if(isset($_GET['id'])){
            $balon_id = $_GET['id'];
            
            foreach($_SESSION['carrito'] as $key => $item){
                if($item['id'] == $balon_id){
                    unset($_SESSION['carrito'][$key]);
                    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                    break;
                }
            }
        }
        
        header("Location: ?controller=carrito&action=index");
        exit();
    }

    /* Vaciar carrito */
    public function vaciar(){
        $_SESSION['carrito'] = array();
        header("Location: ?controller=carrito&action=index");
        exit();
    }

    /* Checkout - Seleccionar cliente */
    public function checkout(){
        $this->page_title = 'Finalizar Compra';
        $this->view = 'checkout';
        
        $data = array();
        $data['carrito'] = $this->getCarritoItems();
        $data['clientes'] = $this->clienteObj->getClientes();
        
        return $data;
    }

    /* Procesar venta */
    public function procesar(){
        if(isset($_POST['cliente_id']) && !empty($_SESSION['carrito'])){
            $cliente_id = $_POST['cliente_id'];
            
            // Validar stock antes de procesar
            $stock_valido = true;
            $productos_sin_stock = array();
            
            foreach($_SESSION['carrito'] as $item){
                $balon = $this->balonObj->getBalonById($item['id']);
                if(!$balon || $balon['stock'] < $item['cantidad']){
                    $stock_valido = false;
                    $productos_sin_stock[] = array(
                        'nombre' => $item['nombre'],
                        'solicitado' => $item['cantidad'],
                        'disponible' => $balon ? $balon['stock'] : 0
                    );
                }
            }
            
            if(!$stock_valido){
                // Guardar info de error en sesión
                $_SESSION['error_stock'] = $productos_sin_stock;
                header("Location: ?controller=carrito&action=checkout&error=insufficient_stock");
                exit();
            }
            
            // Si el stock es válido, procesar la venta
            $venta_id = $this->ventaObj->createVenta($cliente_id, $_SESSION['carrito']);
            
            if($venta_id){
                $_SESSION['carrito'] = array();
                unset($_SESSION['error_stock']);
                header("Location: ?controller=carrito&action=completada&venta_id=".$venta_id);
                exit();
            } else {
                $_SESSION['error_venta'] = true;
                header("Location: ?controller=carrito&action=checkout&error=transaction_failed");
                exit();
            }
        }
        
        header("Location: ?controller=carrito&action=checkout");
        exit();
    }

    /* Venta completada */
    public function completada(){
        $this->page_title = 'Compra Completada';
        $this->view = 'venta_completada';
        
        if(isset($_GET['venta_id'])){
            $venta = $this->ventaObj->getVentaById($_GET['venta_id']);
            $detalle = $this->ventaObj->getDetalleVenta($_GET['venta_id']);
            
            return array(
                'venta' => $venta,
                'detalle' => $detalle
            );
        }
        
        return null;
    }

    /* Obtener items del carrito con totales */
    private function getCarritoItems(){
        $total = 0;
        $cantidad_items = 0;
        
        foreach($_SESSION['carrito'] as $item){
            $total += $item['subtotal'];
            $cantidad_items += $item['cantidad'];
        }
        
        return array(
            'items' => $_SESSION['carrito'],
            'total' => $total,
            'cantidad_items' => $cantidad_items
        );
    }
}

?>