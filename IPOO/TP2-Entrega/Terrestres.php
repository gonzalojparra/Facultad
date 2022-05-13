<?php

class Terrestres extends Viaje {
    // Atributos
    private $importe;
    private $idaOVuelta;
    private $comodidadAsiento;

    // Constructor
    public function __construct( $codViaje, $destino, $cantMaxPasajeros, $responsableViaje, $importe, $idaOVuelta, $comodidadAsiento ) {
        parent::__construct( $codViaje, $destino, $cantMaxPasajeros, $responsableViaje );
        $this->importe = $importe;
        $this->idaOVuelta = $idaOVuelta;
        $this->comodidadAsiento = $comodidadAsiento;
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

    public function getComodidadAsiento(){
        return $this->comodidadAsiento;
    }
    public function setComodidadAsiento( $comodidadAsiento ){
        $this->comodidadAsiento = $comodidadAsiento;
    }

    // toString
    public function __toString() {
        $strPadre = parent::__toString();
        $str = "
        Importe: {$this->getImporte()}.\n
        Tipo de vuelo: {$this->getIdaOVuelta()}.\n
        Comodidad del asiento: {$this->getComodidadAsiento()}.\n";
        return "{$strPadre}{$str}";
    }
}