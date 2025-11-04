<?php

require_once 'model/balon.php';

class balonController
{
    public $page_title;
    public $view;

    public function __construct()
    {
        $this->view = 'list_balon';
        $this->page_title = '';
        $this->balonObj = new Balon();
    }

    /* List all balones */
    public function list()
    {
        $this->page_title = 'Catálogo de Balones';
        return $this->balonObj->getBalones();
    }

    /* Load balon for edit */
    public function edit($id = null)
    {
        $this->page_title = 'Editar Balón';
        $this->view = 'edit_balon';
        if (isset($_GET["id"]))
            $id = $_GET["id"];
        return $this->balonObj->getBalonById($id);
    }

    /* Create new balon */
    public function create()
    {
        $this->page_title = 'Nuevo Balón';
        $this->view = 'edit_balon';
        return null;
    }

    /* Save balon */
    public function save()
    {
        $this->view = 'edit_balon';
        $this->page_title = 'Editar Balón';
        $id = $this->balonObj->save($_POST);
        $result = $this->balonObj->getBalonById($id);
        $_GET["response"] = true;
        return $result;
    }

    /* Confirm to delete */
    public function confirmDelete()
    {
        $this->page_title = 'Eliminar Balón';
        $this->view = 'confirm_delete_balon';
        return $this->balonObj->getBalonById($_GET["id"]);
    }

    /* Delete */
    public function delete()
    {
        $this->page_title = 'Catálogo de Balones';
        $this->view = 'delete_balon';
        return $this->balonObj->deleteBalonById($_POST["id"]);
    }
    public function getConnection()
    {
        $this->getConection(); // Asegura que la conexión esté inicializada
        return $this->conection;
    }
}

?>