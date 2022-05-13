<?php

class Aereos extends Viaje {
    // Atributos
    private $importe;
    private $idaOVuelta;
    private $numVuelo;
    private $catAsiento; // Primera clase o no
    private $airlineName;
    private $cantEscalas;

    // Constructor
    public function __construct( $codViaje, $destino, $cantMaxPasajeros, $responsableViaje, $importe, $idaOVuelta, $numVuelo, $catAsiento, $airlineName, $cantEscalas) {
        // Llama al constructor de la clase padre
        parent::__construct( $codViaje, $destino, $cantMaxPasajeros, $responsableViaje );
        $this->importe = $importe;
        $this->idaOVuelta = $idaOVuelta;
        $this->numVuelo = $numVuelo;
        $this->catAsiento = $catAsiento;
        $this->airlineName = $airlineName;
        $this->cantEscalas = $cantEscalas;
    }

    // Getters & Setters
    public function getImporte(){
        return $this->importe;
    }
    public function setImporte( $importe ){
        $this->importe = $importe;
    }

    public function getIdaOVuelta(){
        return $this->idaOVuelta;
    }
    public function setIdaOVuelta( $idaOVuelta ){
        $this->idaOVuelta = $idaOVuelta;
    }

    public function getNumVuelo(){
        return $this->numVuelo;
    }
    public function setNumVuelo( $numVuelo ){
        $this->numVuelo = $numVuelo;
    }

    public function getCatAsiento(){
        return $this->catAsiento;
    }
    public function setCatAsiento( $catAsiento ){
        $this->catAsiento = $catAsiento;
    }

    public function getAirlineName(){
        return $this->airlineName;
    }
    public function setAirlineName( $airlineName ){
        $this->airlineName = $airlineName;
    }

    public function getCantEscalas(){
        return $this->cantEscalas;
    }
    public function setCantEscalas( $cantEscalas ){
        $this->cantEscalas = $cantEscalas;
    }

    // toString
    public function __toString() {
        // Se asigna el toString de la clase padre a una variable
        $strPadre = parent::__toString();
        $str = "
        Importe: {$this->getImporte()}.\n
        Tipo de vuelo: {$this->getIdaOVuelta()}.\n
        Número de vuelo: {$this->getNumVuelo()}.\n
        Categoría del asiento: {$this->getCatAsiento()}.\n
        Aerolínea: {$this->getAirlineName()}.\n
        Cantidad de escalas: {$this->getCantEscalas()}.\n";
        return "{$strPadre}{$str}";
    }
}