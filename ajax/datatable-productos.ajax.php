<?php

require_once "../controllers/productos.controller.php";
require_once "../models/productos.model.php";

require_once "../controllers/categorias.controller.php";
require_once "../models/categorias.model.php";

class TablaProductos{

    
    public function mostrarTablaProductos(){

        $item = null;
        $valor = null;

        $productos = ControladorProductos::crtMostrarProductos($item, $valor);
        
        $datosJson = '{
            "data": [';
            
            for ($i = 0;$i < count($productos); $i++) { 
                
                $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$productos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>";
                
                $imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";
                
                $tabla = "categorias";
                $item = "id";
                $valor = $productos[$i]['id_categoria'];

                $categoria = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor); 

                if($productos[$i]['stock'] <= 5){
                    $stock = "<button class='btn btn-danger'>".$productos[$i]['stock']."</button>";
                }else if($productos[$i]['stock'] > 5 && $productos[$i]['stock'] <= 10){
                    $stock = "<button class='btn btn-warning'>".$productos[$i]['stock']."</button>";
                }else{
                    $stock = "<button class='btn btn-success'>".$productos[$i]['stock']."</button>";
                }

                $datosJson .= '[
                    "'.($i+1).'",
                    "'.$imagen.'",
                    "'.$productos[$i]['codigo'].'",
                    "'.$productos[$i]['descripcion'].'",
                    "'.$categoria['categoria'].'",
                    "'.$stock.'",
                    "$ '.$productos[$i]['precio_compra'].'",
                    "$ '.$productos[$i]['precio_venta'].'",
                    "'.$productos[$i]['fecha'].'",
                    "'.$botones.'"
                ],';
            }
        

            $datosJson = substr($datosJson, 0, -1);
        $datosJson .= '] 
        }';

        echo $datosJson;

    }
}

/*=============================================
ACTIVAR LA TABLA DE PRODUCTOS
=============================================*/
$activarProductos = new TablaProductos();
$activarProductos -> mostrarTablaProductos();