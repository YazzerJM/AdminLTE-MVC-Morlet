/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/

$('.nuevaFoto').change(function(){
    
    var imagen = this.files[0];
    
    if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
        $(".nuevaFoto").val("");

        Swal.fire({
            title: '¡Error al subir la imagen!',
            text: 'La imagen debe de estar en formato JPG o PNG.',
            icon: 'error',
            confirmButtonText: 'Cerrar'
        });
    }else if(imagen["size"] > 2000000){
        $(".nuevaFoto").val("");

        Swal.fire({
            title: '¡Error al subir la imagen!',
            text: 'La imagen debe pesar más de 2MB.',
            icon: 'error',
            confirmButtonText: 'Cerrar'
        });
    }else{
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);

        $(datosImagen).on("load", function(event){
            
            var rutaImagen = event.target.result;

            $(".previsualizar").attr("src", rutaImagen);
        });
    }
});

/*=============================================
EDITAR USUARIO
=============================================*/

$(document).on("click", ".btnEditarUsuario",function(){

    var idUsuario = $(this).attr("idUsuario");

    var datos = new FormData();
    datos.append("idUsuario", idUsuario);

    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarUsuario").val(respuesta["usuario"]);
            $("#editarPerfil").val(respuesta["perfil"]);
            $("#fotoActual").val(respuesta["foto"]);

            $("#passwordActual").val(respuesta["password"]);

            if(respuesta["foto"] != ""){
                $(".previsualizar").attr("src", respuesta["foto"]);
            }

        }
    });
});

/*=============================================
ACTIVAR USUARIO
=============================================*/

$(document).on("click", ".btnActivar",function(){

    var idUsuario = $(this).attr("idUsuario");
    var estadoUsuario = $(this).attr("estadoUsuario");

    var datos = new FormData();
    datos.append("activarId", idUsuario);
    datos.append("activarUsuario", estadoUsuario);

    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){
            if(window.matchMedia("(max-width:767px)").matches){
                Swal.fire({
                    title: 'El usuario ha sido actualizado',
                    icon: 'success',
                    confirmButtonColor: '#D81B60',
                    confirmButtonText: 'Cerrar',
            
                }).then((result) => {
                    if(result.value){
                        window.location = "usuarios";
                    }
                });
            }
        }
    });

    if(estadoUsuario == 0){
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        $(this).html('Desactivado');
        $(this).attr('estadoUsuario', 1);
    }else{
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-success');
        $(this).html('Activado');
        $(this).attr('estadoUsuario', 0);
    }
});

/*=============================================
REVISAR USUARIO SI YA ESTA REGISTRADO
=============================================*/

$('#nuevoUsuario').change(function(){

    $(".alert").remove();

    var usuario = $(this).val();

    var datos = new FormData();
    datos.append("validarUsuario", usuario);

    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            
            if(respuesta){
                $('#nuevoUsuario').parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');
                $('#nuevoUsuario').val("");
            }

        }
    });
});

/*=============================================
ELIMINAR USUARIO
=============================================*/
$(document).on("click", ".btnEliminarUsuario",function(){

    var idUsuario = $(this).attr("idUsuario");
    var fotoUsuario = $(this).attr("fotoUsuario");
    var usuario = $(this).attr("usuario");

    Swal.fire({
        title: '¿Está seguro de borrar el usuario?',
        text: '¡Si no lo está puede cancelar la acción!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D81B60',
        confirmButtonText: 'Si, borrar usuario',
        cancelButtonText: 'Cancelar'

    }).then((result) => {
        if(result.value){
            window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;
        }
    });
});