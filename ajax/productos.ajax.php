<?php

require_once '../controllers/productos.controller.php';
require_once '../models/productos.model.php';

class AjaxProductos{

    public $idCategoria;

    public function ajaxCrearCodigoProducto(){

        $item = "id_categoria";
        $valor = $this->idCategoria;

        $respuesta = ControladorProductos::crtMostrarProductos($item, $valor);
        
        echo json_encode($respuesta);
    }

    /*=============================================
    EDITAR PRODUCTO
    =============================================*/

    public $idProducto;

    public function ajaxEditarProducto(){

        $item = "id";
        $valor = $this->idProducto;

        $respuesta = ControladorProductos::crtMostrarProductos($item, $valor);
        
        echo json_encode($respuesta);
    }
}

if(isset($_POST["idCategoria"])){
    $codigoProducto = new AjaxProductos();
    $codigoProducto -> idCategoria = $_POST["idCategoria"];
    $codigoProducto -> ajaxCrearCodigoProducto();
}

if(isset($_POST["idProducto"])){
    $editarProducto = new AjaxProductos();
    $editarProducto -> idProducto = $_POST["idProducto"];
    $editarProducto -> ajaxEditarProducto();
}

