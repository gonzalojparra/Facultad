<?php  
require_once('../../config.php');
$objSession = new SessionController();
/* if($objSession->validarCredenciales()){
    $ban = true;
}else{
    $ban = false;
} */
if( $objSession->getUsnombre() != false ){
    require_once('header2.php');
} else {
    /* if(!$ban){
        $ERROR = 'log';
    } */
    require_once('header.php');
}