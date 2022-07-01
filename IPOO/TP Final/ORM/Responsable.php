<?php

class Responsable {
    // Atributos
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    // Constructor
    public function __construct(){
        $this->numEmpleado = '';
        $this->numLicencia = '';
        $this->nombre = '';
        $this->apellido = '';
        $this->mensajeOperacion = '';
    }

    // Getters & Setters
    public function getNumEmpleado(){
        return $this->numEmpleado;
    }
    public function setNumEmpleado($numEmpleado){
        $this->numEmpleado = $numEmpleado;
    }

    public function getNumLicencia(){
        return $this->numLicencia;
    }
    public function setNumLicencia($numLicencia){
        $this->numLicencia = $numLicencia;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    /**
    * Método que realiza los set de los atributos
    */
    public function cargar( $numEmpleado, $numLicencia, $nombre, $apellido ){
        $this->setNumEmpleado( $numEmpleado );
        $this->setNumLicencia( $numLicencia );
        $this->setNombre( $nombre );
        $this->setApellido( $apellido );
    }

    /**
     * Método que busca y devuelve datos del responsable
     * @param int $numEmpleado
     * @return boolean
     */
    public function buscar( $numEmpleado ){
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM responsable WHERE rnumeroempleado = {$numEmpleado}";
        $bandera = false;

        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){
                if( $row2 = $bd->Registro() ){
                    $this->setNumEmpleado( $numEmpleado );
                    $this->setNumLicencia( $row2['rnumerolicencia'] );
                    $this->setNombre( $row2['rnombre'] );
                    $this->setApellido( $row2['rapellido'] );
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
     * Método que lista todos los responsables con la condición recibida
     * Retorna un arreglo con los datos de los responsables
     * @param string $condicion
     * @return array
    */
    public function listar( $condicion = '' ){
        $arregloResponsable = null;
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM responsable";

        // Si la condición no está vacia, se arma un nuevo string para la consulta
        if( $condicion != '' ){
            $consulta = $consulta. ' WHERE ' .$condicion;
        }
        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){				
                $arregloResponsable = array();
                while( $row2 = $bd->Registro() ){
                    $numEmpleado = $row2['rnumeroempleado'];
                    $numLicencia = $row2['rnumerolicencia'];
                    $nombre = $row2['rnombre'];
                    $apellido = $row2['rapellido'];
                    
                    // Creo instancia donde se almacenarán los datos, para luego pushearlos en el array
                    $responsable = new Responsable();
                    $responsable->cargar( $numEmpleado, $numLicencia, $nombre, $apellido );
                    array_push( $arregloResponsable, $responsable );
                }
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $arregloResponsable;
    }

    public function insertar() {
        $bd = new BaseDatos();
        $consulta = "INSERT INTO responsable VALUES ({$this->getNumEmpleado()}, {$this->getNumLicencia()}, '{$this->getNombre()}', '{$this->getApellido()}')";
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
        $consulta = "UPDATE responsable SET rnumerolicencia = {$this->getNumLicencia()}, rnombre = '{$this->getNombre()}', rapellido = '{$this->getApellido()}' WHERE rnumeroempleado = {$this->getNumEmpleado()}";
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

    public function eliminar( $numEmpleado ){
        $bd = new BaseDatos();
        $consulta = "DELETE FROM responsable WHERE rnumeroempleado = $numEmpleado";
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
        Número de empleado: {$this->getNumEmpleado()}.\n
        Número de licencia: {$this->getNumLicencia()}.\n
        Nombre: {$this->getNombre()}.\n
        Apellido: {$this->getApellido()}.\n";
        return $str;
    }

}