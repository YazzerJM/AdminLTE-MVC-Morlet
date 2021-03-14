<?php

class ControladorUsuarios {

    static public function ctrIngresoUsuario(){
        
        if(isset($_POST['ingUsuario'])){
            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
               preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

                $encriptar = crypt($_POST["ingPassword"], '$2a$07$usesomesillystringforsalt$');

                $tabla = "usuarios";

                $item = "usuario";
                $valor = $_POST['ingUsuario'];

                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
                
                if(is_array($respuesta)){
                    if($respuesta["usuario"] == $_POST['ingUsuario'] && $respuesta["password"] == $encriptar){

                        if($respuesta["estado"] == 1){
                            $_SESSION['iniciarSesion'] = 'ok';
                            $_SESSION['id'] = $respuesta["id"];
                            $_SESSION['nombre'] = $respuesta["nombre"];
                            $_SESSION['usuario'] = $respuesta["usuario"];
                            $_SESSION['foto'] = $respuesta["foto"];
                            $_SESSION['perfil'] = $respuesta["perfil"];

                            /*=============================================
                            REGISTRAR FECHA PARA SABER EL ULTIMO LOGIN
                            =============================================*/

                            date_default_timezone_set('America/Mexico_City');

                            $fecha = date('Y-m-d');
                            $hora = date('H:i:s');

                            $fechaActual = $fecha.' '.$hora;

                            $tabla = "usuarios";

                            $item1 = "ultimo_login";
                            $valor1 = $fechaActual;

                            $item2 = "id";
                            $valor2 = $respuesta["id"];

                            $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

                            if($ultimoLogin == "ok"){
                                echo '<script> window.location = "inicio"</script>';
                            }

    
                        }else{
                            echo '<br><div class="alert alert-danger">El usuario aún no está activado</div>';
                        }

                    }else{
                        echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
                    }
                }else{
                    echo '<br><div class="alert alert-danger">El usuario no existe</div>';
                }

            }
        }
    }

    static public function ctrCrearUsuario(){
        if(isset($_POST["nuevoUsuario"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
               preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
               preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){


                /*=============================================
                VALIDAR IMAGEN
                =============================================*/

                $ruta = "";

                if(isset($_FILES["nuevaFoto"]["tmp_name"])){

                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/

                    $directorio = "views/images/usuarios/".$_POST["nuevoUsuario"];
                    mkdir($directorio, 0777, true);

                    if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "views/images/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    }

                    if($_FILES["nuevaFoto"]["type"] == "image/png"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "views/images/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";

                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }

                }


                $tabla = "usuarios";

                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$usesomesillystringforsalt$');
                
                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "usuario" => $_POST["nuevoUsuario"],
                    "password" => $encriptar,
                    "perfil" => $_POST["nuevoPerfil"],
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlIngresarUsuarios($tabla, $datos);

                if($respuesta == "ok"){
                    echo "<script>

                            Swal.fire({
                                type: 'success',
                                title: '¡El usuario ha sido guardado correctamente!',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                            }).then((result) => {
                                if(result.value){
                                    window.location = 'usuarios';
                                }
                            });

                        </script>";
                }


            }else{
                echo "<script>

                        Swal.fire({
                            type: 'error',
                            title: '¡El usuario no puede ir vacío o llevar caracteres especiales!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                        }).then((result) => {
                            if(result.value){
                                window.location = 'usuarios';
                            }
                        });

                    </script>";
            }
        }
    }

    static public function ctrMostrarUsuarios($item, $valor){

        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ctrEditarUsuario(){

        if(isset($_POST["editarUsuario"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){
                
                /*=============================================
                VALIDAR IMAGEN
                =============================================*/

                $ruta = $_POST["fotoActual"];
                var_dump($ruta);

                if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                    CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    =============================================*/

                    $directorio = "views/images/usuarios/".$_POST["editarUsuario"];

                    /*=============================================
                    PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA DB
                    =============================================*/

                    if(!empty($_POST["fotoActual"])){
                        unlink($_POST["fotoActual"]);
                    }else{
                        if(!is_dir($directorio)){
                            mkdir($directorio, 0777, true);
                        }
                    }


                    if($_FILES["editarFoto"]["type"] == "image/jpeg"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "views/images/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    }

                    if($_FILES["editarFoto"]["type"] == "image/png"){
                        /*=============================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================*/

                        $aleatorio = mt_rand(100,999);

                        $ruta = "views/images/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }

                }

                $tabla = "usuarios";

                if($_POST["editarPassword"] != ""){

                    if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){
                        $encriptar = crypt($_POST["editarPassword"], '$2a$07$usesomesillystringforsalt$');
                    }else{
                        echo "<script>

                                Swal.fire({
                                    type: 'error',
                                    title: '¡El usuario no puede ir vacío o llevar caracteres especiales!',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    closeOnConfirm: false
                                }).then((result) => {
                                    if(result.value){
                                        window.location = 'usuarios';
                                    }
                                });
            
                            </script>";
                    }

                }else{
                    $encriptar = $_POST["passwordActual"];
                }

                $datos = array(
                    "nombre" => $_POST["editarNombre"],
                    "usuario" => $_POST["editarUsuario"],
                    "password" => $encriptar,
                    "perfil" => $_POST["editarPerfil"],
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlEditarUsuarios($tabla, $datos);

                if($respuesta == "ok"){
                    echo "<script>

                        Swal.fire({
                            type: 'success',
                            title: '¡El usuario ha sido editado correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                        }).then((result) => {
                            if(result.value){
                                window.location = 'usuarios';
                            }
                        });

                    </script>";
                }
            }else{
                echo "<script>

                        Swal.fire({
                            type: 'error',
                            title: '¡El nombre no puede ir vacío o llevar caracteres especiales!',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                        }).then((result) => {
                            if(result.value){
                                window.location = 'usuarios';
                            }
                        });

                    </script>";
            }

        }
    }

    /*=============================================
    BORRAR USUARIO
    =============================================*/

    static public function ctrBorrarUsuario(){
        if(isset($_GET["idUsuario"])){
            $tabla = "usuarios";
            $datos = $_GET["idUsuario"];

            if($_GET["fotoUsuario"] != ""){
                unlink($_GET["fotoUsuario"]);
                rmdir("views/images/usuarios/".$_GET["usuario"]);
            }

            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

            if($respuesta == "ok"){
                echo "<script>

                        Swal.fire({
                            type: 'success',
                            title: '¡El usuario ha sido borrado correctamente!',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                        }).then((result) => {
                            if(result.value){
                                window.location = 'usuarios';
                            }
                        });

                    </script>";
            }

            
        }
    }

}