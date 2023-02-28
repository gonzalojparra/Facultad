<?php
require_once('../../../config.php');

$objUsuarioRol = new UsuarioRolController();
$data = Data::buscarKey( 'nombre' );

$respuesta = false;
if( $data != null ){
    $rta = $objUsuarioRol->insertar();
    if($rta['respuesta']){
        $respuesta = true;
    }
    if(!$respuesta){
        $mensaje = "La accion no pudo completarse";
    }
}

$retorno['respuesta'] = $respuesta;
if( isset($mensaje) ){
    $retorno['errorMsg'] = $mensaje;
}

echo json_encode($retorno);