<?php
require_once('Empresa.php');
require_once('Responsable.php');


class Viaje {
    // Atributos
    private $idviaje;
    private $vdestino;
    private $cantmaxpasajeros;
    private $idobjempresa;
    private $objresponsable;
    private $vimporte;
    private $tipoasiento;
    private $idayvuelta;
    private $arrayPasajeros;
    private $mensajeOperacion;

    // Constructor
    public function __construct() {
        $this->idviaje = '';
        $this->vdestino = '';
        $this->cantmaxpasajeros = '';
        $this->vimporte = '';
        $this->tipoasiento = '';
        $this->idayvuelta = '';
        $this->arrayPasajeros = [];
        $this->mensajeOperacion = '';
    }

    // Getters & Setters
    public function getIdviaje(){
        return $this->idviaje;
    }
    public function setIdviaje($idviaje){
        $this->idviaje = $idviaje;
    }

    public function getVdestino(){
        return $this->vdestino;
    }
    public function setVdestino($vdestino){
        $this->vdestino = $vdestino;
    }

    public function getCantmaxpasajeros(){
        return $this->cantmaxpasajeros;
    }
    public function setCantmaxpasajeros($cantmaxpasajeros){
        $this->cantmaxpasajeros = $cantmaxpasajeros;
    }

    public function getIdobjempresa(){
        return $this->idobjempresa;
    }
    public function setIdobjempresa($idobjempresa){
        $this->idobjempresa = $idobjempresa;
    }

    public function getObjresponsable(){
        return $this->objresponsable;
    }
    public function setObjresponsable($objresponsable){
        $this->objresponsable = $objresponsable;
    }

    public function getVimporte(){
        return $this->vimporte;
    }
    public function setVimporte($vimporte){
        $this->vimporte = $vimporte;
    }

    public function getTipoasiento(){
        return $this->tipoasiento;
    }
    public function setTipoasiento($tipoasiento){
        $this->tipoasiento = $tipoasiento;
    }

    public function getIdayvuelta(){
        return $this->idayvuelta;
    }
    public function setIdayvuelta($idayvuelta){
        $this->idayvuelta = $idayvuelta;
    }

    public function getArrayPasajeros(){
        return $this->arrayPasajeros;
    }

    public function setArrayPasajeros($arrayPasajeros){
        $this->arrayPasajeros = $arrayPasajeros;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar( $idviaje, $vdestino, $cantmaxpasajeros, $idobjempresa, $objresponsable, $vimporte, $tipoasiento, $idayvuelta ){
        $this->setIdviaje( $idviaje );
        $this->setVdestino( $vdestino );
        $this->setCantmaxpasajeros( $cantmaxpasajeros );
        $this->setIdobjempresa( $idobjempresa );
        $this->setObjresponsable( $objresponsable );
        $this->setVimporte( $vimporte );
        $this->setTipoasiento( $tipoasiento );
        $this->setIdayvuelta( $idayvuelta );
    }

    /**
     * M??todo que busca y devuelve datos del viaje
     * @param int $idviaje
     * @return boolean
     */
    public function buscar( $idviaje ){
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM viaje WHERE idviaje = " .$idviaje;
        $bandera = false;

        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){
                if( $row2 = $bd->Registro() ){
                    $this->setIdviaje( $idviaje );
                    $this->setVdestino( $row2['vdestino'] );
                    $this->setCantmaxpasajeros( $row2['vcantmaxpasajeros'] );

                    $objEmpresa = new Empresa();
                    $objEmpresa->buscar($row2['idempresa']);
                    $this->setIdobjempresa( $objEmpresa );

                    $objResponsable = new Responsable();
                    $objResponsable->buscar($row2['rnumeroempleado']);
                    $this->setObjresponsable( $objResponsable );

                    $this->setVimporte( $row2['vimporte'] );
                    $this->setTipoasiento( $row2['tipoAsiento'] );
                    $this->setIdayvuelta( $row2['idayvuelta'] );
                    $bandera = true;
                }
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $bandera;
    }

    /**
     * M??todo que lista todos los viajes con la condici??n recibida
     * Retorna un arreglo con los datos de los viajes
     * @param string $condicion
     * @return array
    */
    public function listar( $condicion = '' ){
        $arregloViaje = null;
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM viaje";

        // Si la condici??n no est?? vacia, se arma un nuevo string para la consulta
        if( $condicion != '' ){
            $consulta = $consulta. ' WHERE ' .$condicion;
        }
        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){				
                $arregloViaje = array();
                while( $row2 = $bd->Registro() ){
                    $idviaje = $row2['idviaje'];
                    $destino = $row2['vdestino'];
                    $cantmaxpasajeros = $row2['vcantmaxpasajeros'];

                    $objempresa = new Empresa();
                    $idempresa = $row2['idempresa'];
                    $objempresa->buscar($idempresa);
                    $objEmpresa = $objempresa;
                    $objresponsable = new Responsable();
                    $numeroempleado = $row2['rnumeroempleado'];
                    $objresponsable->buscar($numeroempleado);
                    $objResponsable = $objresponsable;

                    $importe = $row2['vimporte'];
                    $tipoasiento = $row2['tipoAsiento'];
                    $idavuelta = $row2['idayvuelta'];
                    // Creo instancia donde se almacenar??n los datos, para luego pushearlos en el array
                    $viaje = new Viaje();
                    $viaje->cargar( $idviaje, $destino, $cantmaxpasajeros, $objEmpresa, $objResponsable, $importe, $tipoasiento, $idavuelta );
                    array_push( $arregloViaje, $viaje );
                }
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $arregloViaje;
    }

    public function insertar() {
        $bd = new BaseDatos();

        $objEmpresa = $this->getIdobjempresa();
        $idEmpresa = $objEmpresa->getIdempresa();

        $objResponsable = $this->getObjresponsable();
        $numEmpleado = $objResponsable->getNumEmpleado();
        
        $consulta = "INSERT INTO viaje VALUES ({$this->getIdviaje()}, '{$this->getVdestino()}', {$this->getCantmaxpasajeros()}, $idEmpresa, $numEmpleado, {$this->getVimporte()}, '{$this->getTipoasiento()}', '{$this->getIdayvuelta()}')";
        
        $bandera = false;
        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){
                $bandera = true;
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $bandera;
    }

    public function modificar() {
        $bd = new BaseDatos();

        $objEmpresa = $this->getIdobjempresa();
        $idEmpresa = $objEmpresa->getIdempresa();

        $objResponsable = $this->getObjresponsable();
        $numEmpleado = $objResponsable->getNumEmpleado();

        $consulta = "UPDATE viaje SET idviaje = {$this->getIdviaje()}, vdestino = '{$this->getVdestino()}', vcantmaxpasajeros = {$this->getCantmaxpasajeros()}, idempresa = $idEmpresa, rnumeroempleado = $numEmpleado, vimporte = {$this->getVimporte()}, tipoAsiento = '{$this->getTipoasiento()}', idayvuelta = '{$this->getIdayvuelta()}' WHERE idviaje = {$this->getIdviaje()}";
        $bandera = false;

        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){
                $bandera = true;
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $bandera;
    }

    public function eliminar() {
        $bd = new BaseDatos();
        $consulta = "DELETE FROM viaje WHERE idviaje = {$this->getIdviaje()}";
        $bandera = false;
        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){
                $bandera = true;
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $bandera;
    }

    // toString
    public function __toString() {
        $str = "
        ID: {$this->getIdviaje()}.\n
        Destino: {$this->getVdestino()}.\n
        Cantidad m??xima de pasajeros: {$this->getCantmaxpasajeros()}.\n
        ID Empresa: {$this->getIdobjempresa()->getIdempresa()}.\n
        Responsable: Empleado N?? {$this->getObjresponsable()->getNumEmpleado()}.\n
        Importe: {$this->getVimporte()} pesos.\n
        Tipo de asiento: {$this->getTipoasiento()}.\n
        Ida y Vuelta: {$this->getIdayvuelta()}.\n";
        return $str;
    }

}