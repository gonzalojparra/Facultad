<?php
//NO USARLO PORQUE STA AL PEDO
class CompraestadoController extends MasterController {
    use Errores;

    //crea array para la busqueda
    public function busqueda(){
        $arrayBusqueda = [];
        $idcompraestado = Data::buscarKey('idcompraestado');
        $idcompra = Data::buscarKey('idcompra');
        $idcompraestadotipo = Data::buscarKey('idcompraestadotipo');
        $cefechaini = Data::buscarKey('cefechaini');
        $arrayBusqueda = ['idcompraestado' => $idcompraestado,
                          'idcompra' => $idcompra,
                          'idcompraestadotipo' => $idcompraestadotipo,
                          'cefechaini' => $cefechaini,
                          ];
        return $arrayBusqueda;
    }

    public function listarTodo($arrayBusqueda){
        //$arrayBusqueda = $this->busqueda();
        //$arrayBusqueda['cefechafin'] = NULL;
        $arrayTotal = Compraestado::listar($arrayBusqueda);
        if(array_key_exists('array', $arrayTotal)){
            $array = $arrayTotal['array'];
        }else{
            $array = [];
        }
        
        //var_dump($array);
        return $array;        
    }

    public function buscarId(){
        $respuesta['respuesta'] = false;
        $respuesta['obj'] = null;
        $respuesta['error'] = '';
        $arrayBusqueda = [];
        $arrayBusqueda['idcompraestado'] = Data::buscarKey('idcompraestado');
        $objCompraestado = new Compraestado();
        $rta = $objCompraestado->buscar($arrayBusqueda);
        //var_dump($objCompraestado);
        if($rta['respuesta']){
            $respuesta['respuesta'] = true;
            $respuesta['obj'] = $objCompraestado;
        }else{
            $respuesta['error'] = $rta;
        }
        return $respuesta;        
    }

    public function insertarCompraEstadoNueva($idcompra){
        $objCompraEstado = new Compraestado();
        //generar objeto de compraestadotipo
        $arrBusCET['idcompraestadotipo'] = 1;
        $objCompraEstadoTipo = new Compraestadotipo();
        $objCompraEstadoTipo->buscar($arrBusCET);
        //generar objeto de compra 
        $arrBusC['idcompra'] = $idcompra;
        $objCompra = new Compra();
        $objCompra->buscar($arrBusC);
        $objCompraEstado->cargar($objCompra, $objCompraEstadoTipo);
        $rsta = $objCompraEstado->insertar();
        if($rsta['respuesta']){
            $response = true;
        }else{
            $response = false;
        }
        return $response;
    }


    //
    public function insertar(){
        $data = $this->busqueda();
        $objCompraestado = new Compraestado();
        $objCompraestado->setIdcompraestado($data['idcompraestado']);
        $objCompra = new Compra();
        $objCompra->buscar($data['idcompra']);
        $objCompraestado->setObjCompra($objCompra);
        $objCompraestadotipo = new Compraestado();
        $objCompraestadotipo->buscar($data['idcompraestadotipo']);
        $objCompraestado->setObjCompraestadotipo($objCompraestadotipo);
        $objCompraestado->setCefechaini($data['cefechaini']);
        $objCompraestado->setCefechafin($data['cefechafin']);
        $rta = $objCompraestado->insertar();
        return $rta;
    }

    

    public function modificar(){
        $rta = $this->buscarId();
        $response = false;
        if($rta['respuesta']){
            //puedo modificar con los valores
            $valores = $this->busqueda();
            
            $objCompraestado = $rta['obj'];
            /* $objCompraestado->cargar($valores['idcompraestado'], $valores['idcompra'], $valores['idcompraestadotipo'], $valores['cefechaini'], $valores['cefechafin']); */

            $objCompra = new Compra();
            $arridcompra = ['idcompra' => $valores['idcompra']];
            $objCompra->buscar($arridcompra);
            $objCompraestado->setObjCompra($objCompra);

            $objCompraestadotipo = new Compraestadotipo();
            $arridcompraestadotpo = ['idcompraestadotipo' => $valores['idcompraestadotipo']];
            /* var_dump($arridcompraestadotpo);
            die(); */
            $objCompraestadotipo->buscar($arridcompraestadotpo);
            $objCompraestado->setObjCompraestadotipo($objCompraestadotipo);

            $rsta = $objCompraestado->modificar();
            if($rsta['respuesta']){
                //todo gut
                $response = true;
            }
        }else{
            //no encontro el obj
            $response = false;
        }
        return $response;
    }


    public function eliminar(){
        $rta = $this->buscarId();
        $response = false;
        if( $rta['respuesta'] ){
            $objProducto = $rta['obj'];
            $respEliminar = $objProducto->eliminar();
            if( $respEliminar['respuesta'] ){
                $response = true;
            }
        } else {
            //no encontro el obj
            $response = false;
        }
        return $response;
    }

    public function obtenerCompraActivaPorId($idcompra){
        $arrBus = [];
        $arrBus['idcompra'] = $idcompra;
        $arrBus['idcompraestadotipo'] = 1;
        $arrBus['cefechafin'] = NULL;
        $objCompraEstado = new Compraestado();
        $rta = $objCompraEstado->buscar($arrBus);
        $respuesta = false;
        if($rta['respuesta']){
            //salio bien la query
            if($objCompraEstado->getObjCompra()->getIdcompra() != NULL){
                //hay una compra activa
                $respuesta = $objCompraEstado->getObjCompra()->getIdcompra();
            }
        }
        return $respuesta;
    }

    //ponemos la fecha de hoy para el cambio de estado
    public function setearfecha(){
        $rta = $this->buscarId();
        $sepudo = [];
        $hoy = date("Y-m-d H:i:s");
        if(!is_null($rta['obj'])){
            $objetoCompraestado = $rta['obj'];
            $objetoCompraestado->setCefechafin($hoy);
            $sepudo['respuesta'] = true;
            $sepudo['objmodif'] = $objetoCompraestado;
        }else{
            $sepudo['respuesta'] = false;
            
        }
        return $sepudo;
        
    }

    //para modificar la fecha y modificarla en la base de datos
    public function modificarFechafin(){
        $arrayCompraestado = $this->buscarId();
        $objCompraestado = $arrayCompraestado['obj'];
        $fechafin = date("Y-m-d H:i:s");
        $objCompraestado->setCefechafin($fechafin);
        $rta = $objCompraestado->modificar();
        if($rta['respuesta']){
            $respuesta = true;
        }else{
            $respuesta  = false;
        }
        return $respuesta;
        
        
    }

    public function crearNuevoestadoElegido(){
        $array = [];
        $objCompraestado = new Compraestado();
        //tengo objeto compra
        $array ['idcompra'] = Data::buscarKey('idcompra');
        $objCompra = new Compra();
        $objCompra->buscar($array);
        //tengo objeto compraestadotipo
        $arrayBusquedasT = [];
        $arrayBusquedasT ['idcompraestadotipo'] = Data::buscarKey('idcompraestadotipo');
        $objCompraestadotipo = new Compraestadotipo();
        $objCompraestadotipo->buscar($arrayBusquedasT);
        //cargo el nuevo compraestado con el estadotipo nuevo
        $objCompraestado->cargar($objCompra, $objCompraestadotipo);
        $rta = $objCompraestado->insertar();
        if($rta){
            $respuesta ['respuesta'] = true;
        }else{
            $respuesta ['respuesta'] = false;
        }
        
        return $respuesta;
    }
    

    //HACER FUNCION PARA RESTAR LA CANTIDAD DE PRODUCTOS.
    //tengo que traer la compra, el compraitem y producto
    public function cambiarStocksegunEstado($objCompraestado){
        //buscar el valor de la key enviada cmo compraestadotipo
        $data = Data::buscarKey('idcompraestadotipo');
        //obtengo el obj compra que tiene el objeto
        $objCompra = $objCompraestado->getObjCompra();
        //obtengo el obj estadotipo que tiene sin el cambio
        //$estadotipoObj = $objCompraestado->getObjCompraestadotipo();
        //obtengo el id de la compra
        $idCompra = $objCompra->getIdcompra();
        //hacemos bandera
        $respuesta = [];                
        //creo un array para realizar la bsuqueda de eso en el parametro en compraitem
        $array = [];
        $array['idcompra'] = $idCompra;
        //$objCompraitem = new Compraitem();
        $arraycompraitem = Compraitem::listar($array);
        if(array_key_exists('array', $arraycompraitem)){
            $listaCompraitem = $arraycompraitem['array'];
            foreach ($listaCompraitem as $key => $value) {
                $objCompraitem = $value;
                $cantidadComprada = $objCompraitem->getCicantidad();
                $producto = $objCompraitem->getObjProducto();
                $cantidadtotal = $producto->getProCantStock();
                if($data == "2"){
                    if($cantidadtotal > $cantidadComprada){
                        $totalyn = $cantidadtotal - $cantidadComprada;
                        $producto->setProCantStock($totalyn);
                        $respuesta['respuesta'] = true;
                        
                    }else{
                        $mensaje = "Tiene stock insuficiente";
                        $respuesta['mensaje'] = $mensaje;
                        $respuesta['respuesta'] = false;
                        
                    }
                }elseif ($data == 4) {
                    //hacer que vuelva a sumar el stock
                    $totalito = $cantidadtotal + $cantidadComprada;
                    $producto->setProCantStock($totalito);
                    $respuesta['respuesta'] = true;
                }elseif ($data == 3) {
                        //se deja igual el stock pero se envia true para que siga el proceso
                        $respuesta['respuesta'] = true;
                }else{
                    $mensaje = "Debe cambiar el estado tipo";
                    $respuesta['mensaje'] = $mensaje;
                    $respuesta['respuesta'] = false;
                }    
            } 
        }else{
            $respuesta['respuesta'] = false;
            $respuesta['mensaje'] = "No existen items en su compra";  
        }
        return $respuesta;    
    }

    public function modificarEstado($idcompraestado, $idcompraestadotipo){
        $objCompraEstado = new Compraestado();
        $arrBusCompraEstado['idcompraestado'] = $idcompraestado;
        $rta = $objCompraEstado->buscar($arrBusCompraEstado);
        if($rta['respuesta']){
            //cambio de estado
            $objCompraestadotipo = new Compraestadotipo();
            $arrB['idcompraestadotipo'] = $idcompraestadotipo;
            $objCompraestadotipo->buscar($arrB);
            $objCompraEstado->setObjCompraestadotipo($objCompraestadotipo);
            $bandera = $objCompraEstado->modificar();
            if($bandera['respuesta']){
                $respuesta = true;
            }else{
                $respuesta = false;
            }
        }else{
            $respuesta = false;
        }
        return $respuesta;
    }

    public function modificacion( $data ){
        $idCompraEstado = $data['POST']['idcompraestado'];
        if( $idCompraEstado != NULL || $idCompraEstado !=  false ){
            //$objCompraEstadoCon = new CompraestadoController();
            $rta = $this->buscarId($idCompraEstado);
            if( array_key_exists('obj', $rta) ){
                //encontro el objCompraEstado
                $objCompraEstado = $rta['obj'];
                $ObjCompraEstadoTipoActual = $objCompraEstado->getObjCompraestadotipo();
                $idCompraEstadoTipoPorParametro = $data['POST']['idcompraestadotipo'];
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
                        $idCompraEstado = $data['POST']['idcompraestado'];
                        $rta = $this->modificarEstado($idCompraEstado, $idcompraestadotipo);
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
                        $idCompraEstado = $data['POST']['idcompraestado'];
                        $rta = $this->modificarEstado($idCompraEstado, $idcompraestadotipo);
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
                        $rsss = $this->modificarEstado($idcompraestado, $idcompraestadotipo);
                        $envioMail = Mailer::notificarCambioEstado( $mailUsuario, 'Su compra ha sido enviada!' );
                        $response = true;
                    } elseif( $idCompraEstadoTipoPorParametro == 4 ){
                        $idcompraestado = $objCompraEstado->getIdcompraestado();
                        $idcompraestadotipo = 4;
                        $objCompra = new Compra();
                        $objCompra->buscar( array('idcompra' => $idcompraestado) );
                        $objUsuario = $objCompra->getObjUsuario();
                        $mailUsuario = $objUsuario->getUsmail();
                        $rsss = $this->modificarEstado($idCompraestado, $idcompraestadotipo);
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

        return $retorno;
    }
    
}
