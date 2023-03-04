<?php
require_once( '../templates/header.php');

$objUsuario = new UsuarioController();
$objUsuarioRol = new UsuarioRolController();

$data = Data::getDatos();

$respuesta = $objUsuario->insertar();
$usuarioCreado = $objUsuario->buscarObjUsuario2();
$rta = $objUsuario->cargarNuevoCliente( $usuarioCreado['obj'] );

if( $rta == false ){
    echo('Ocurrió un error en la creación del usuario');
} else {
    ?>
    <script>
        location.href = '../home/index.php';
    </script>
    <?php
}