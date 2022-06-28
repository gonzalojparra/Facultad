<?php

class Pasajero {
    // Atributos
    private $rdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $objviaje;
    private $mensajeOperacion;

    // Constructor
    public function __construct() {
        $this->rdocumento = '';
        $this->pnombre = '';
        $this->papellido = '';
        $this->ptelefono = '';
        $this->objviaje = new Viaje();
        $this->mensajeOperacion = '';
    }

    // Getters & Setters
    public function getRdocumento(){
        return $this->rdocumento;
    }
    public function setRdocumento($rdocumento){
        $this->rdocumento = $rdocumento;
    }

    public function getPnombre(){
        return $this->pnombre;
    }
    public function setPnombre($pnombre){
        $this->pnombre = $pnombre;
    }

    public function getPapellido(){
        return $this->papellido;
    }
    public function setPapellido($papellido){
        $this->papellido = $papellido;
    }

    public function getPtelefono(){
        return $this->ptelefono;
    }
    public function setPtelefono($ptelefono){
        $this->ptelefono = $ptelefono;
    }

    public function getObjviaje(){
        return $this->objviaje;
    }
    public function setObjviaje($objviaje){
        $this->objviaje = $objviaje;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar( $rdocumento, $pnombre, $papellido, $ptelefono, $objviaje ){
        $this->rdocumento = $rdocumento;
        $this->pnombre = $pnombre;
        $this->papellido = $papellido;
        $this->ptelefono = $ptelefono;
        $this->objviaje = $objviaje;
    }

    /**
     * Método que busca y devuelve datos del pasajero
     * @param int $rdocumento
     * @return boolean
     */
    public function buscar( $rdocumento ){
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM pasajero WHERE rdocumento = " .$rdocumento;
        $bandera = false;

        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){
                if( $row2 = $bd->Registro() ){
                    $this->setRdocumento( $rdocumento );
                    $this->setPnombre( $row2['pnombre'] );
                    $this->setPapellido( $row2['papellido'] );
                    $this->setPtelefono( $row2['ptelefono'] );
                    $this->setObjviaje( $row2['idviaje'] );
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
     * Método que lista todos los pasajeros con la condición recibida
     * Retorna un arreglo con los datos de los pasajeros
     * @param string $condicion
     * @return array
    */
    public static function listar( $condicion = '' ){
        $arregloPasajeros = null;
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM viaje";

        // Si la condición no está vacia, se arma un nuevo string para la consulta
        if( $condicion != '' ){
            $consulta = $consulta. ' WHERE ' .$condicion;
        }
        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){				
                $arregloPasajeros = array();
                while( $row2 = $bd->Registro() ){
                    $rdocumento = $row2['rdocumento'];
                    $pnombre = $row2['pnombre'];
                    $papellido = $row2['papellido'];
                    $ptelefono = $row2['ptelefono'];
                    $idviaje = $row2['idviaje'];

                    // Creo instancia donde se almacenarán los datos, para luego pushearlos en el array
                    $pasajero = new Pasajero();
                    $pasajero->cargar( $rdocumento, $pnombre, $papellido, $ptelefono, $idviaje );
                    array_push( $arregloPasajeros, $pasajero );
                }
            } else {
                // $this->setMensajeOperacion( $bd->getError() );
                Pasajero::setMensajeOperacion( $bd->getError() );
            }
        } else {
            // $this->setMensajeOperacion( $bd->getError() );
            Pasajero::setMensajeOperacion( $bd->getError() );
        }
        return $arregloPasajeros;
	}

    public function insertar() {
        $bd = new BaseDatos();
        $consulta = "INSERT INTO pasajero VALUES ({$this->getRdocumento()}, {$this->getPnombre()}, {$this->getPapellido()}, {$this->getPtelefono()}, {$this->getObjviaje()})";
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
        $consulta = "UPDATE pasajero SET rdocumento = {$this->getRdocumento()}, pnombre = {$this->getPnombre()}, papellido = {$this->getPapellido()}, ptelefono = {$this->getPtelefono()}, idviaje = {$this->getObjViaje()}";
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

    public function eliminar( $rdocumento ){
        $bd = new BaseDatos();
        $consulta = "DELETE FROM pasajero WHERE rdocumento = $rdocumento";
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
        $idViaje = $this->getObjviaje()->getIdviaje();
        $str = "
        DNI: {$this->getRdocumento()}.\n
        Nombre: {$this->getPnombre()}.\n
        Apellido: {$this->getPapellido()}.\n
        Telefono: {$this->getPtelefono()}.\n
        ID Viaje: $idViaje.\n";
        return $str;
    }
    
}