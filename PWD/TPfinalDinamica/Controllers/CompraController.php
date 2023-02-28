<?php
//require_once('../config.php');
class CompraController extends MasterController{
    use Errores;

    public function busqueda() {
        $arrayBusqueda = [];
        $idCompra = Data::buscarKey('idcompraestadotipo');
        $cofecha = Data::buscarKey('cofecha');
        $idusuario = Data::buscarKey('idusuario');
        $arrayBusqueda = [
            'idcompra' => $idCompra,
            'cofecha' => $cofecha,
            'idusuario' => $idusuario
        ];
        return $arrayBusqueda;
    }

    public function listarTodo( $arr ){
        $arrayTotal = Compra::listar($arr);
        if($arrayTotal['respuesta']){
            $array = $arrayTotal['array'];
        }else{
            $array = [];
        }
        
        return $array;        
    }


    public function buscarId() {
        $idBusqueda = Data::buscarKey( 'idcompraestadotipo' );
        if( $idBusqueda == false ){
            // Error
            $data['error'] = $this->warning( 'No se ha encontrado dicho registro' );
        } else {
            // Encontrado!
            $array['idcompraestadotipo'] = $idBusqueda;
            $objCompraestadotipo = new Compraestadotipo();
            $rta = $objCompraestadotipo->buscar( $array['idcompraestadotipo'] );
            if( $rta['respuesta'] == false ){
                $data['error'] = $this->manejarError( $rta );
            } else {
                $data['array'] = $objCompraestadotipo;
            }
            return $data;
        }
    }

    public function buscarIdDos() {
        $rta = false;
        $idBusqueda = [];
        $idBusqueda['idcompra'] = Data::buscarKey('idcompra');
        $objCompra = new Compraestadotipo();
        $objEncontrado = $objCompra->buscar($idBusqueda);
        if($objEncontrado['respuesta']){
            $rta['respuesta'] = true;
            $rta['obj'] = $objCompra;
        }
        return $rta;
    }

    public function insertar() {
        $data = $this->busqueda();
        $objCompraestadotipo = new Compraestadotipo();
        $objCompraestadotipo->setIdcompraestadotipo($data['idcompraestadotipo']);
        $objCompraestadotipo->setCetdescripcion($data['cetdescripcion']);
        $objCompraestadotipo->setCetdetalle($data['cetdetalle']);
        $rta = $objCompraestadotipo->insertar();
        return $rta;
    }

    public function modificar() {
        $rta = $this->buscarIdDos();
        $response = false;
        if($rta['respuesta']){
            // Puedo modificar con los valores
            $valores = $this->busqueda();
            $objCompraestadotipo = $rta['obj'];
            $objCompraestadotipo->cargar($valores['cetdescripcion'], $valores['cetdetalle']);
            $rsta = $objCompraestadotipo->modificar();
            if($rsta['respuesta']){
                $response = true;
            }
        }
        return $response;
    }

    public function eliminar() {
        $rta = $this->buscarIdDos();
        $response = false;
        if($rta['respuesta']){
            $objCompraestadotipo = $rta['obj'];
            $respEliminar = $objCompraestadotipo->eliminar();
            if($respEliminar['respuesta']){
                $response = true;
            }
        }else{
            // No encontro el obj
            $response = false;
        }
        return $response;
    }

    public function buscarCompraConIdusuario( $idusuario ){
        $arrBus = [];
        $arrBus['idusuario'] = $idusuario;
        $objCompra = new Compra();
        $rta = $objCompra->buscar($arrBus);
        if($rta['respuesta']){
            $respuesta = $objCompra->getIdcompra();
        }else{
            $respuesta = false;
        }
        return $respuesta;
    }

    public function buscarCompraIdusuario( $idusuario ){
        $arrBus = [];
        $arrBus['idusuario'] = $idusuario;
    }

    public function crearCompraDevolverId( $idusuario ){
        $objCompra = new Compra();
        $objUsuario = new Usuario();
        $arrBusUs = [];
        $arrBusUs['idusuario'] = $idusuario;
        $rsa = $objUsuario->buscar($arrBusUs);
        $objCompra->cargar($objUsuario);
        $rta = $objCompra->insertar();
        if( $rta['respuesta'] ){
            // Se pudo crear la compra
            $rrrta = $objCompra->ultimaCompraId();
            if( $rrrta['respuesta'] ){
                $bandera = true;
                $quepaso = $objCompra->getIdcompra();
                $objCompraestado = new Compraestado();
                $objCompraestadoTipo = new Compraestadotipo();
                $arrBuCET['idcompraestadotipo'] = 1;
                $objCompraestadoTipo->buscar($arrBuCET);
                $objCompraestado->cargar($objCompra, $objCompraestadoTipo);
                $objCompraestado->insertar();
            } else {
                $quepaso = false;
            }
        } else {
            $quepaso = false;
        }
        return $quepaso;
          
    }

}