<div class="content-wrapper">

    <section class="content-header">

      <h1>
        Administrar Usuarios
      </h1>

      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar usuarios</li>
      </ol>

    </section>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar usuario</button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Foto</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Último login</th>
                <th>Acciones</th>
              </tr>
            </thead>

            <tbody>

            <?php

              $item = null;
              $valor = null;

              $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
            ?>

            <?php foreach ($usuarios as $key => $value){ ?>
              <tr>
                <td><?php echo $value["id"] ?></td>
                <td><?php echo $value["nombre"] ?></td>
                <td><?php echo $value["usuario"] ?></td>

                <?php if ($value["foto"] != ""){ ?>
                  <td><img src="<?php echo $value["foto"] ?>" class="img-thumbnail" width="40px"></td>
                <?php } else {?>
                  <td><img src="views/images/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>
                <?php } ?>
                
                <td><?php echo $value["perfil"] ?></td>

                <?php if ($value["estado"] != 0){ ?>
                  <td><button class="btn btn-success btn-xs btnActivar" idUsuario="<?php echo $value["id"]; ?>" estadoUsuario="0">Activado</button></td>
                <?php } else {?>
                  <td><button class="btn btn-danger btn-xs btnActivar" idUsuario="<?php echo $value["id"]; ?>" estadoUsuario="1">Desactivado</button></td>
                <?php } ?>
                <td><?php echo $value["ultimo_login"] ?></td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-warning btnEditarUsuario" idUsuario="<?php echo $value["id"]; ?>" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btnEliminarUsuario" idUsuario="<?php echo $value["id"]; ?>" usuario="<?php echo $value["usuario"]; ?>" fotoUsuario="<?php echo $value["foto"]; ?>"><i class="fa fa-times"></i></button>
                  </div>
                </td>
              </tr>
            <?php } ?>

            </tbody>

          </table>
        </div>

      </div>

  </section>

</div>

<!--===========================================--- 
MODAL AGREGAR USUARIO
----===========================================-->

<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">

        <div class="modal-header" style="background: #D81B60; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Usuario</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTREDA PARA EL NOMBRE -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar nombre" required>
              </div>
            </div>

            <!-- ENTRADA PARA EL USUARIO -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingresar usuario" required>
              </div>
            </div>

            <!-- ENTRADA PARA LA CONTRASEÑA -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="nuevoPassword" placeholder="Ingresar contraseña" required>
              </div>
            </div>
            
            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="nuevoPerfil">
                  <option value="">Seleccion perfil</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especila">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="nuevaFoto" name="nuevaFoto">
              <p class="help-block">Peso máximo de la foto 2MB</p>
              <img src="views/images/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
            </div>


          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar usuario</button>
        </div>
        
        <?php 

          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();

        ?>
      </form>

    </div>

  </div>
</div>

<!--===========================================--- 
MODAL EDITAR USUARIO
----===========================================-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">

        <div class="modal-header" style="background: #D81B60; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Usuario</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTREDA PARA EL NOMBRE -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>
              </div>
            </div>

            <!-- ENTRADA PARA EL USUARIO -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" id="editarUsuario" name="editarUsuario" value="" readonly>
              </div>
            </div>

            <!-- ENTRADA PARA LA CONTRASEÑA -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="editarPassword" placeholder="Escriba una nueva contraseña">
                <input type="hidden" id="passwordActual" name="passwordActual">
              </div>
            </div>
            
            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" id="editarPerfil" name="editarPerfil">
                  <option value="Administrador">Administrador</option>
                  <option value="Especila">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="nuevaFoto" name="editarFoto">
              <p class="help-block">Peso máximo de la foto 2MB</p>
              <img src="views/images/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              <input type="hidden" id="fotoActual" name="fotoActual">
            </div>


          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar usuario</button>
        </div>
        
        <?php 

          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();

        ?>
      </form>

    </div>

  </div>
</div>

<?php 

  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();

?>



