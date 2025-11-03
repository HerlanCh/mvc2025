<?php 

require_once 'model/ball.php';

class ballController{
    public $page_title;
    public $view;
    public $ballObj;

    public function __construct() {
        $this->view = 'list_ball';
        $this->page_title = 'Tienda de Balones';
        $this->ballObj = new Ball();
    }

    /* List all balls */
    public function list(){
        $this->page_title = 'Catálogo de Balones';
        return $this->ballObj->getBalls();
    }

    /* Load ball for edit */
    public function edit($id = null){
        $this->page_title = 'Editar Balón';
        $this->view = 'edit_ball';
        if(isset($_GET["id"])) $id = $_GET["id"];
        return $this->ballObj->getBallById($id);
    }

    /* Create or update ball */
    public function save(){
        $this->view = 'edit_ball';
        $this->page_title = 'Guardar Balón';
        $id = $this->ballObj->save($_POST);
        $result = $this->ballObj->getBallById($id);
        $_GET["response"] = true;
        return $result;
    }

    /* Confirm to delete */
    public function confirmDelete(){
        $this->page_title = 'Eliminar Balón';
        $this->view = 'confirm_delete_ball';
        return $this->ballObj->getBallById($_GET["id"]);
    }

    /* Delete */
    public function delete(){
        $this->page_title = 'Catálogo de Balones';
        $this->view = 'delete_ball';
        return $this->ballObj->deleteBallById($_POST["id"]);
    }

    /* View ball details */
    public function detail(){
        $this->page_title = 'Detalles del Balón';
        $this->view = 'detail_ball';
        return $this->ballObj->getBallById($_GET["id"]);
    }

}

?>