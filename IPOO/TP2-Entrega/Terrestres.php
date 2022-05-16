<?php

class Terrestres extends Viaje {
    // Atributos
    private $importe;
    private $idaOVuelta;
    private $comodidadAsiento; // Semicama o cama

    // Constructor
    public function __construct( $codViaje, $destino, $cantMaxPasajeros, $responsableViaje, $importe, $idaOVuelta, $comodidadAsiento ) {
        // Llama al constructor de la clase padre
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

    /**
     * Calcula el importe del pasaje
     * Si el asiento es cama, se incrementa un 25%
     * Si el viaje es de ida y vuelta, se incrementa un 50%
     * @param void
     * @return float
     */
    public function calcImporte() {
        $importe = $this->getImporte();
        if( $this->getComodidadAsiento() == 'Cama' ){
            $importe *= 1.25;
        }
        if( $this->getIdaOVuelta() == 'Ida y Vuelta' ){
            $importe *= 1.5;
        }
        return $importe;
    }

    // toString
    public function __toString() {
        // Se asigna el toString de la clase padre a una variable
        $strPadre = parent::__toString();
        $str = "
        Importe: {$this->getImporte()}.\n
        Tipo de vuelo: {$this->getIdaOVuelta()}.\n
        Comodidad del asiento: {$this->getComodidadAsiento()}.\n";
        return "{$strPadre}{$str}";
    }
}