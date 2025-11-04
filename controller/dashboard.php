<?php

require_once 'model/balon.php';
require_once 'model/cliente.php';
require_once 'model/venta.php';

class dashboardController
{
    public $page_title;
    public $view;

    public function __construct()
    {
        $this->view = 'dashboard';
        $this->page_title = 'Dashboard';
        $this->balonObj = new Balon();
        $this->clienteObj = new Cliente();
        $this->ventaObj = new Venta();
    }

    /* Dashboard principal */
    public function index()
    {
        $this->page_title = 'Dashboard - Panel de Control';

        $data = array();

        // Estadísticas generales
        $data['total_productos'] = count($this->balonObj->getBalones());
        $data['total_clientes'] = $this->clienteObj->getTotalClientes();
        $data['total_ventas'] = $this->ventaObj->getTotalVentas();
        $data['total_ingresos'] = $this->ventaObj->getTotalIngresos();

        // Productos con stock bajo
        $data['stock_bajo'] = $this->getProductosStockBajo();

        // Productos más caros
        $data['productos_caros'] = $this->getProductosMasCaros();

        // Valor total del inventario
        $data['valor_inventario'] = $this->getValorInventario();

        // Productos por deporte
        $data['productos_por_deporte'] = $this->getProductosPorDeporte();

        // Ventas recientes
        $data['ventas_recientes'] = $this->ventaObj->getVentasRecientes(5);

        // Productos sin stock
        $data['sin_stock'] = $this->getProductosSinStock();

        return $data;
    }

    /* Productos con stock bajo (menos de 10) */
    private function getProductosStockBajo()
    {
        $this->balonObj->getConection();
        $sql = "SELECT * FROM balon WHERE stock > 0 AND stock < 10 ORDER BY stock ASC";
        $stmt = $this->balonObj->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* Productos más caros */
    private function getProductosMasCaros($limit = 5)
    {
        $this->balonObj->getConection();
        $limit = (int) $limit;
        $sql = "SELECT * FROM balon ORDER BY precio DESC LIMIT $limit";
        $stmt = $this->balonObj->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    /* Valor total del inventario */
    private function getValorInventario()
    {
        $this->balonObj->getConection();
        $sql = "SELECT SUM(precio * stock) as total FROM balon";
        $stmt = $this->balonObj->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /* Productos por deporte */
    private function getProductosPorDeporte()
    {
        $this->balonObj->getConection();
        $sql = "SELECT deporte, COUNT(*) as cantidad, SUM(stock) as total_stock 
                FROM balon 
                GROUP BY deporte 
                ORDER BY cantidad DESC";
        $stmt = $this->balonObj->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* Productos sin stock */
    private function getProductosSinStock()
    {
        $this->balonObj->getConection();
        $sql = "SELECT * FROM balon WHERE stock = 0";
        $stmt = $this->balonObj->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>