/*=============================================
EDITAR CATEGORIA
=============================================*/

$(document).on("click", ".btnEditarCategoria",function(){
    
    var idCategoria = $(this).attr("idCategoria");
  
    var datos = new FormData();
    datos.append("idCategoria", idCategoria);

    $.ajax({
        url: "ajax/categorias.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            $("#editarCategoria").val(respuesta["categoria"]);
            $("#idCategoria").val(respuesta["id"]);

        }
    });
});

/*=============================================
ELIMINAR CATEGORIA
=============================================*/

$(document).on("click", ".btnEliminarCategoria",function(){

    var idCategoria = $(this).attr("idCategoria");

    Swal.fire({
        title: '¿Está seguro de borrar la categoría?',
        text: '¡Si no lo está puede cancelar la acción!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D81B60',
        confirmButtonText: 'Si, borrar la categoría',
        cancelButtonText: 'Cancelar'

    }).then((result) => {
        if(result.value){
            window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;
        }
    });
});