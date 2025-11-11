<?php

class Venta
{
    private $table = 'venta';
    private $conection;

    public function __construct()
    {
    }

    public function getConection()
    {
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }

    /* Obtener todas las ventas */
    public function getVentas()
    {
        $this->getConection();
        $sql = "SELECT v.*, CONCAT(c.nombre, ' ', c.apellido) as cliente_nombre 
                FROM " . $this->table . " v 
                INNER JOIN cliente c ON v.cliente_id = c.id 
                ORDER BY v.id DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* Venta por Id */
    public function getVentaById($id)
    {
        if (is_null($id))
            return false;
        $this->getConection();
        $sql = "SELECT v.*, CONCAT(c.nombre, ' ', c.apellido) as cliente_nombre, c.email, c.telefono 
                FROM " . $this->table . " v 
                INNER JOIN cliente c ON v.cliente_id = c.id 
                WHERE v.id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /* Get detalle venta */
    public function getDetalleVenta($venta_id)
    {
        $this->getConection();
        $sql = "SELECT dv.*, b.nombre, b.marca, b.imagen 
                FROM detalle_venta dv 
                INNER JOIN balon b ON dv.balon_id = b.id 
                WHERE dv.venta_id = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$venta_id]);
        return $stmt->fetchAll();
    }

    /* Crear venta desde el carrito  */
    public function createVenta($cliente_id, $carrito)
    {
        $this->getConection();

        try {
            $this->conection->beginTransaction();

            // Calcular total
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['subtotal'];
            }

            // Insertar venta
            $sql = "INSERT INTO " . $this->table . " (cliente_id, total, estado) VALUES(?, ?, 'Completada')";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$cliente_id, $total]);
            $venta_id = $this->conection->lastInsertId();

            // Insertar detalles y actualizar stock
            foreach ($carrito as $item) {
                $sql = "INSERT INTO detalle_venta (venta_id, balon_id, cantidad, precio_unitario, subtotal) 
                        VALUES(?, ?, ?, ?, ?)";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([
                    $venta_id,
                    $item['id'],
                    $item['cantidad'],
                    $item['precio'],
                    $item['subtotal']
                ]);

                // Actualizar stock
                $sql = "UPDATE balon SET stock = stock - ? WHERE id = ?";
                $stmt = $this->conection->prepare($sql);
                $stmt->execute([$item['cantidad'], $item['id']]);
            }

            $this->conection->commit();
            return $venta_id;

        } catch (Exception $e) {
            $this->conection->rollBack();
            return false;
        }
    }

    /* Total de ventas*/
    public function getTotalVentas()
    {
        $this->getConection();
        $sql = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }

    /* Total de Ingresos */
    public function getTotalIngresos()
    {
        $this->getConection();
        $sql = "SELECT SUM(total) as total_ingresos FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total_ingresos'] ?? 0;
    }

    /* Ventas Recientes */
    public function getVentasRecientes($limit = 5)
    {
        $this->getConection();
        $limit = (int) $limit; // asegurar que sea entero
        $sql = "SELECT v.*, CONCAT(c.nombre, ' ', c.apellido) as cliente_nombre 
            FROM " . $this->table . " v 
            INNER JOIN cliente c ON v.cliente_id = c.id 
            ORDER BY v.fecha_venta DESC 
            LIMIT $limit";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

?>