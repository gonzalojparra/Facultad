<?php
require_once('../../../config.php');
$objSession = new SessionController();
$objCompraItemCon = new CompraitemController();

try {
    $rol = $objSession->getRolPrimo();
    $lista = [];
    if($rol == 'Admin' || $rol == 'Deposito'){
        $arrBuCI = [];
        $list = $objCompraItemCon->listarTodo($arrBuCI);
    }else{
        //averiguar las compras del chabon
        $idusuario = $objSession->getIdusuario();
        if($idusuario != NULL){
            //averiguar la compra que tenga activa
            $objCompraCon = new CompraController();
            $idcompra = $objCompraCon->buscarCompraConIdusuario($idusuario);
            
            if($idcompra != NULL){
                //ver que la compra este iniciada 
                $objCompraestadoCon = new CompraestadoController();
                $return = $objCompraestadoCon->obtenerCompraActivaPorId($idcompra);
                //var_dump($return);
                if($return != false){
                    $arrBuCI = [];
                    $arrBuCI['idcompra'] = $return;
                    $list = $objCompraItemCon->listarTodo($arrBuCI);
                    //var_dump($list);
                }else{
                    $list = [];
                }
                
            }else{
                $list = [];
            }
        }
        if(count($list) > 0){
            foreach ($list as $key => $value) {
                $objProd = $value->getObjProducto();
                $objCompra = $value->getObjCompra();
                $arrDat = ['idcompraitem' => $value->getIdcompraitem(), 'idproducto' => $objProd->getIdproducto(), 'pronombre' => $objProd->getPronombre(), 'idcompra' => $objCompra->getIdcompra(), 'cicantidad' => $value->getCicantidad()];
                array_push($lista, $arrDat);
            }
        }
    }
} catch (\Throwable $th) {
    $rol = '';
    $lista = [];
}

/* $idUsuario = $objSession->getIdusuario();
$idCompra =  $objCompraController->buscarCompraConIdusuario( $idUsuario );
$arrayBusqueda = ['idcompra' => $idCompra];
$lista = $objCompraItemController->listarTodo( $arrayBusqueda ); */
//$lista = $objCompraItemControler->listarTodo();

/* $arraydelacompraitem = [];
foreach( $lista as $key => $objCompraItem ){
    /* $arraydelacompraitem = []; 
    $idcompraitem = $objCompraItem->getIdcompraitem();
    $producto = $objCompraItem->getObjProducto();
    $nombreproduct = $producto->getProNombre();
    $idproducto = $producto->getIdProducto();
    $compra = $objCompraItem->getObjCompra();
    $idcompra = $compra->getIdcompra();
    $cantidadComprada = $objCompraItem->getCicantidad();
    $nuevoElemen = [
        'idcompraitem' =>$idcompraitem,
        'idproducto' =>$idproducto,
        'pronombre' =>$nombreproduct,
        'idcompra' =>$idcompra,
        'cicantidad' =>$cantidadComprada,
    ];
    array_push($arraydelacompraitem, $nuevoElemen);
} */
//var_dump($arreglo_salid);
echo json_encode($lista);
