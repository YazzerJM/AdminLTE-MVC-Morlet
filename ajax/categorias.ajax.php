<?php

require_once "../controllers/categorias.controller.php";
require_once "../models/categorias.model.php";

class AjaxCategorias{

    public $idCategoria;

    public function ajaxEditarCategoria(){
        $item = "id";
        $valor = $this->idCategoria;

        $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

        echo json_encode($respuesta);
    }
}

if(isset($_POST["idCategoria"])){
    $categoria = new AjaxCategorias();

    $categoria -> idCategoria = $_POST["idCategoria"];
    $categoria -> ajaxEditarCategoria();
}