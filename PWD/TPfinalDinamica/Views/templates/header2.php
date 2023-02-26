<?php
//nueva sesion 
require_once('../../config.php');
//require_once('preheader.php');

//$objSession = new SessionController();

// Cambios de maxi
// Cambios de Gonza, acá se valida cual header usar
// Validar si las credenciales estan correctas 
$rta = $objSession->activa();

    /* $variable = $objSession->obtenerRol();
    $rol = $variable[0]->getObjRol()->getRodescripcion();
    $menu[0] = 'Usuarios'; */
    $roles = $objSession->obtenerRol();
    //var_dump($roles);
    $rolesArr = [];
    foreach ($roles as $key => $value) {
        $rol = $value->getObjRol();
        $idrol = $rol->getIdrol();
        $rolStr = $rol->getRodescripcion();
        $rolesArr[$idrol] = $rolStr;
    }
    //var_dump($rolesArr);
    foreach ($rolesArr as $key => $value) {
        if (!isset($rolPrimo)) {
            $rolPrimo = $value;
            $rolPrimoId = $key;
        }
    }
    $objSession->setRolPrimo($rolPrimo, $rolPrimoId);
    $menuesDelUsuario = $objSession->obtenerMenues();
    //var_dump($menuesDelUsuario);

    $menuesTotales = $objSession->obtenerTodosMenues();
    

    
    /* $obtenerURL = explode('/', $_SERVER['REQUEST_URI']);
    $obtenerURL = array_reverse($obtenerURL);
    $var = 'ABM';
    $urlActual = $var.$obtenerURL[1];
    //var_dump($urlActual);
    $bandera = true;
    foreach ($menuesDelUsuario as $key => $value) {
        if($value == $urlActual || $urlActual == 'ABMhome'){
            $bandera = false;
        }
    } */
    
    //var_dump($bandera);
    if($objSession->tienePermiso()){
        $_GET['error'] = 'permiso';
        header($PRINCIPAL."?error=permiso");
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Yonny</title>
        <link rel="icon" type="image/x-icon" href="../../Public/img/favicon.png">
        <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
        <script>
            var botmanWidget = {
                introMessage: 'Bienvenido',
                frameEndpoint: '../../Vendor/botman/chat.php',
                chatServer: '../../Vendor/botman/botman.php',
                introMessage: 'Bienvenid@ soy <b>Yonny</b><br>En que puedo servirle?', //saludo inicial
                title: 'Asistente Yonny', //titulo del chat
                dateTimeFormat: 'Y-m-d H:i:s', //formato con el cual trabajaremos
                placeholderText: 'Enviar mensaje...',
                mainColor: '#27ae60', //encabezado
                bubbleBackground: '#219150', //burbuja//el sobre es el icono predeterminado
                // bubbleAvatarUrl: '../Archivos/icono.png',
                aboutText: 'Producido por el grupo Copado',
            }
        </script>
        <!-- CSS -->
        <link rel="stylesheet" href="../../Public/cssPuro/newStyle.css">
        <!-- Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!-- Swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../../Public/bootstrap-5.2.2-dist/css/bootstrap.min.css">

        <link rel="stylesheet" href="../../Vendor/themes/default/easyui.css">
        <link rel="stylesheet" href="../../Vendor/themes/icon.css">
        <link rel="stylesheet" href="../../Vendor/themes/color.css">

    </head>

    <body>
        <!-- Header -->
        <header class="header">


            <div class="header-1">
                <a href="../home/index.php" class="logo"><i class="fas fa-book"></i> Yonny</a>

                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
                    <li class="nav-item dropdown user">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <button class="btn btn-outline-danger me-2" type="button"><?php echo ($objSession->getUsnombre()); ?> - <span><?php echo ($objSession->getRolPrimo()); ?></span></button>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../logs/logout.php">Salir</a></li>
                        </ul>
                    </li>
                </div>

            </div>
            </nav>

        </header>

        <body>

            <!-- Mostrar los menues -->
            <div class="header-2">
                <nav class="navbar">
                    <?php
                    foreach ($menuesTotales as $key => $value) {
                        $menombre = $value['menombre'];
                        $melink = $value['medescripcion'];
                        foreach ($menuesDelUsuario as $llave => $valor) {
                            if ($valor == $menombre) {
                                echo "<a href=\"../../$melink\">$menombre</a>";
                            }
                        }
                    }

                    ?>
                </nav>
            </div>

        <?php //} ?>