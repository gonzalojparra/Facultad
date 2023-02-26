<?php
require_once('../../../config.php');
require( '../../../Vendor/phpmailer/phpmailer/src/PHPMailer.php' );
require( '../../../Vendor/phpmailer/phpmailer/src/SMTP.php' );
require( '../../../Vendor/phpmailer/phpmailer/src/Exception.php' );

$objCompraEstadoTipoCon = new CompraestadotipoController();

$idCompraEstado = $objCompraEstadoTipoCon->buscarKey('idcompraestado');
if( $idCompraEstado != NULL || $idCompraEstado !=  false ){
    $objCompraEstadoCon = new CompraestadoController();
    $rta = $objCompraEstadoCon->buscarId($idCompraEstado);
    if( array_key_exists('obj', $rta) ){
        //encontro el objCompraEstado
        $objCompraEstado = $rta['obj'];
        $ObjCompraEstadoTipoActual = $objCompraEstado->getObjCompraestadotipo();
        $idCompraEstadoTipoPorParametro = $objCompraEstadoTipoCon->buscarKey('idcompraestadotipo');
        if( $idCompraEstadoTipoPorParametro == '2' || $idCompraEstadoTipoPorParametro == 2 ){
            // Opción Aceptada, resta stock.
            $objCompra = $objCompraEstado->getObjCompra(); 
            $idCompra = $objCompra->getIdcompra();
            $objUsuario = $objCompra->getObjUsuario();
            $mailUsuario = $objUsuario->getUsmail();
            $objCompraItemCon = new CompraitemController();
            $arrBusIdCompra['idcompra'] = $idCompra;
            $listaCarrito = $objCompraItemCon->listarTodo( $arrBusIdCompra );
            $banderaSePuedeDescontar = false;
            foreach( $listaCarrito as $key => $value ){
                $cicantidad = $value->getCicantidad();
                $objProducto = $value->getObjproducto();
                $stock = $objProducto->getProCantStock();
                if( $cicantidad > $stock ){
                    $banderaSePuedeDescontar = true;
                }
            }
            if( !$banderaSePuedeDescontar ){
                // A descontar stock
                foreach( $listaCarrito as $key => $value ){
                    $cicantidad = $value->getCicantidad();

                    $objProducto = $value->getObjProducto();
                    $stock = $objProducto->getProCantStock();

                    $nuevoStock = $stock - $cicantidad;
                    $rta = $objProducto->setProCantStock( $nuevoStock );
                    $rta = $objProducto->modificar();
                }
                // Cambiar estado tupla y generar una nueva de compraestado; 5
                $idcompraestadotipo = 2;
                $idCompraEstado = $objCompraEstadoCon->buscarKey( 'idcompraestado' );
                $rta = $objCompraEstadoCon->modificarEstado($idCompraEstado, $idcompraestadotipo);
                if( $rta ){
                    $response = true;
                    $envioMail = Mailer::notificarCambioEstado( $mailUsuario, 'Su compra ha sido aceptada!' );
                } else {
                    $response = false;
                }
            } else {
                $response = false;
                $mensaje = 'Un producto supera el stock';
            }
        } elseif( $idCompraEstadoTipoPorParametro == '4' || $idCompraEstadoTipoPorParametro == 4 || $idCompraEstadoTipoPorParametro == '1' || $idCompraEstadoTipoPorParametro == 1 ){
            // Cancelada, devuelve stock.
            $objCompra = $objCompraEstado->getObjCompra(); 
            $idCompra = $objCompra->getIdcompra();
            $objUsuario = $objCompra->getObjUsuario();
            $mailUsuario = $objUsuario->getUsmail();
            $objCompraItemCon = new CompraitemController();
            $arrBusIdCompra['idcompra'] = $idCompra;
            $listaCarrito = $objCompraItemCon->listarTodo( $arrBusIdCompra );
            $banderaSePuedeSumar = false;
            foreach( $listaCarrito as $key => $value ){
                $cicantidad = $value->getCicantidad();
                $objProducto = $value->getObjproducto();
                $stock = $objProducto->getProCantStock();
                if( $cicantidad < $stock ){
                    $banderaSePuedeSumar = true;
                }
            }
            if( $banderaSePuedeSumar ){
                // A sumar stock
                foreach( $listaCarrito as $key => $value ){
                    $cicantidad = $value->getCicantidad();

                    $objProducto = $value->getObjProducto();
                    $stock = $objProducto->getProCantStock();

                    /* if( $stock >= $cicantidad ){
                       $nuevoStock = $stock;
                    } else { */
                        $nuevoStock = $stock + $cicantidad;
                    /* } */
                    $rta = $objProducto->setProCantStock( $nuevoStock );
                    $rta = $objProducto->modificar();
                }
                // Cambiar estado tupla y generar una nueva de compraestado; 5
                if( $idCompraEstadoTipoPorParametro == 4 || $idCompraEstadoTipoPorParametro == '4' ){
                    $idcompraestadotipo = 4;
                    $cuerpoMail = 'Su compra ha sido cancelada.';
                } else {
                    $idcompraestadotipo = 1;
                    $cuerpoMail = 'Su compra ha sido iniciada!';
                }
                $idCompraEstado = $objCompraEstadoCon->buscarKey( 'idcompraestado' );
                $rta = $objCompraEstadoCon->modificarEstado($idCompraEstado, $idcompraestadotipo);
                if( $rta ){
                    $response = true;
                    $envioMail = Mailer::notificarCambioEstado( $mailUsuario, $cuerpoMail );
                } else {
                    $response = false;
                }
            } else {
                $response = false;
                $mensaje = 'Ha ocurrido un error.';
            }
        } else {
            //cambio de estado solamente 5
            if( $idCompraEstadoTipoPorParametro == 3 ){
                $idcompraestado = $objCompraEstado->getIdcompraestado();
                $idcompraestadotipo = 3;
                $objCompra = new Compra();
                $idcompra = $objCompra->getIdcompra();
                $objCompra->buscar( array('idcompra' => $idcompra) );
                $objUsuario = $objCompra->getObjUsuario();
                /* var_dump( $objUsuario );
                die; */
                $mailUsuario = $objUsuario->getUsmail();
                $rsss = $objCompraEstadoCon->modificarEstado($idcompraestado, $idcompraestadotipo);
                $envioMail = Mailer::notificarCambioEstado( $mailUsuario, 'Su compra ha sido enviada!' );
                $response = true;
            } elseif( $idCompraEstadoTipoPorParametro == 4 ){
                $idcompraestado = $objCompraEstado->getIdcompraestado();
                $idcompraestadotipo = 4;
                $objCompra = new Compra();
                $objCompra->buscar( array('idcompra' => $idcompraestado) );
                $objUsuario = $objCompra->getObjUsuario();
                $mailUsuario = $objUsuario->getUsmail();
                $rsss = $objCompraEstadoCon->modificarEstado($idCompraestado, $idcompraestadotipo);
            }
        }
    } else {
        // No lo encontró
        $response = false;
        $mensaje = 'No se encontró el Obj de Compra Estado';
    }
}

$retorno['respuesta'] = $response;
if(isset($mensaje)){
    $retorno['errorMsg'] = $mensaje;
}

echo json_encode($retorno);