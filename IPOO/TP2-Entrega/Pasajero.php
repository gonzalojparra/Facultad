<?php

class Pasajero {
    //Atributos
    private $nombre; // string
    private $apellido; // string
    private $numDNI; // int
    private $telefono; // int

    //Construct
    public function __construct( $nombre, $apellido, $numDNI, $telefono ) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->numDNI = $numDNI;
        $this->telefono = $telefono;
    }

    //Getters & Setters
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

    public function getNumDNI(){
        return $this->numDNI;
    }
    public function setNumDNI($numDNI){
        $this->numDNI = $numDNI;
    }

    public function getTelefono(){
        return $this->telefono;
    }
    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    //toString
    public function __toString() {
        $str = "
        Nombre: {$this->getNombre()}.\n
        Apellido: {$this->getApellido()}.\n
        Número de documento: {$this->getNumDNI()}.\n
        Telefono: {$this->getTelefono()}.\n";
        return $str;
    }
}