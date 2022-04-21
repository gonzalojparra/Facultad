<?php

class ResponsableV {
    // Atributos
    private $numEmpleado; // int
    private $numLicencia; // int
    private $nombre; // string
    private $apellido; // string

    // Construct
    public function __construct( $numEmpleado, $numLicencia, $nombre, $apellido ) {
        $this->numEmpleado = $numEmpleado;
        $this->numLicencia = $numLicencia;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
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