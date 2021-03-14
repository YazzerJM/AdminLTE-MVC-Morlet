<header class="main-header">
    <!--===========================================--- 
                LOGOTIPO
    ----===========================================-->
    <a href="inicio" class="logo">
        <!-- Logo mini -->
        <span class="logo-mini">
            <!-- <img src="views/images/plantilla/icono-blanco.png" class="img-responsive" style="padding:3px"> -->
            <b>M</b>
        </span>

        <!-- Logo normal -->
        <span class="logo-lg">
            <!-- <img src="views/images/plantilla/icono-blanco-lineal.png" class="img-responsive" style="padding:10px 0px"> -->
            <b>M</b>orlet Studio
        </span>
    </a>

    <!--===========================================--- 
                BARRA DE NAVEGACION
    ----===========================================-->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Boton de navegacion -->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Perfil de usuario -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    
                        <?php if ($_SESSION["foto"] != ""){ ?>
                            <img src="<?php echo $_SESSION["foto"]; ?>" class="user-image">
                        <?php } else {?>
                            <img src="views/images/usuarios/default/anonymous.png" class="user-image">
                        <?php } ?>

                        <span class="hidden-xs"><?php echo $_SESSION["nombre"]; ?></span>
                    </a>

                    <!-- Dropdown-toggle -->
                    <ul class="dropdown-menu">
                        <li class="user-body">
                            <div class="pull-right">
                                <a href="salir" class="btn btn-default btn-flat">Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>



</header>