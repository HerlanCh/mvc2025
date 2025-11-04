<?php

require_once 'model/cliente.php';

class clienteController
{
    public $page_title;
    public $view;

    public function __construct()
    {
        $this->view = 'list_cliente';
        $this->page_title = '';
        $this->clienteObj = new Cliente();
    }

    /* List all clientes */
    public function list()
    {
        $this->page_title = 'Gestión de Clientes';
        return $this->clienteObj->getClientes();
    }

    /* Create new cliente */
    public function create()
    {
        $this->page_title = 'Nuevo Cliente';
        $this->view = 'edit_cliente';
        return null;
    }

    /* Load cliente for edit */
    public function edit($id = null)
    {
        $this->page_title = 'Editar Cliente';
        $this->view = 'edit_cliente';
        if (isset($_GET["id"]))
            $id = $_GET["id"];
        return $this->clienteObj->getClienteById($id);
    }

    /* Save cliente */
    public function save()
    {
        $this->view = 'edit_cliente';
        $this->page_title = 'Editar Cliente';
        $id = $this->clienteObj->save($_POST);
        $result = $this->clienteObj->getClienteById($id);
        $_GET["response"] = true;
        return $result;
    }

    /* Confirm to delete */
    public function confirmDelete()
    {
        $this->page_title = 'Eliminar Cliente';
        $this->view = 'confirm_delete_cliente';
        return $this->clienteObj->getClienteById($_GET["id"]);
    }

    /* Delete */
    public function delete()
    {
        $this->page_title = 'Gestión de Clientes';
        $this->view = 'delete_cliente';
        return $this->clienteObj->deleteClienteById($_POST["id"]);
    }
    public function getConnection()
    {
        $this->getConection(); // Asegura que la conexión esté inicializada
        return $this->conection;
    }
}


?>