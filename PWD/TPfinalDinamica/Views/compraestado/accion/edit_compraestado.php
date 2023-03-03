<?php
require_once('../../../config.php');
require( '../../../Vendor/phpmailer/phpmailer/src/PHPMailer.php' );
require( '../../../Vendor/phpmailer/phpmailer/src/SMTP.php' );
require( '../../../Vendor/phpmailer/phpmailer/src/Exception.php' );

$compraEstadoController = new CompraestadoController();

$data = Data::data();
$resultado = $compraEstadoController->modificacion( $data );

echo json_encode($resultado);