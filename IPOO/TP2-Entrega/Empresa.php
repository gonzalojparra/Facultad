<?php

class Empresa {
    // Atributos
    private $nombre;
    private $arrayViajes = [];

    // Constructor
    public function __construct( $nombre ) {
        $this->nombre = $nombre;
    }

    // Getters & Setters
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre( $nombre ){
        $this->nombre = $nombre;
    }

    public function getArrayViajes(){
        return $this->arrayViajes;
    }
    public function setArrayViajes( $arrayViajes ){
        $this->arrayViajes = $arrayViajes;
    }

    /**
     * Método que convierte el arreglo de viajes a string
     * @param void
     * @return string
     */
    public function arrayViajesToString() {
        $str = "";
        $coleccion = $this->getArrayViajes();
        $i = 0;
        for( $i; $i < count($coleccion); $i++ ) {
            $str .= "\t {$coleccion[$i]} \n";
        }
        return $str;
    }

    /**
     * Método que vende un pasaje
     * @param object $objPasajero
     * @return float
     */
    public function venderPasaje( $objPasajero ) {
        $importeFinal = null;
        $viajesArr = $this->getArrayViajes();
        $i = 0;
        $noEncontrado = true;
        while( $noEncontrado && ($i < count($viajesArr)) ) {
            $viaje = $viajesArr[$i];
            $lugarDisponible = $viaje->lugarDisponible();
            if( $lugarDisponible ) {
                $noEncontrado = false;
                $posicion = $i; // Se guarda la posición donde se encontró el viaje con lugar disponible
            }
        }
        if( !$noEncontrado ) {
            $agregado = $viaje->agregarPasajero( $objPasajero );
            if( $agregado ) {
                $importeFinal = $viaje->calcImporte();
                $arrayViajes[$posicion] = $viaje;
                $this->setArrayViajes( $arrayViajes );
            }
        }
        return $importeFinal;
    }

    /**
     * Método que busca un viaje
     */
    public function buscarViaje( $numViaje ) {
        $i = 0;
        $viajesArr = $this->getArrayViajes();
        $noEncontrado = true;
        while( $noEncontrado && ($i < count($viajesArr)) ){
            $viaje = $viajesArr[$i];
            $num = $viaje->getCodViaje();
            if( $num == $numViaje ){
                $noEncontrado = false;
                $posicion = $i;
            }
        }
        if( $noEncontrado ) {
            $posicion = null;
        }
        return $posicion;
    }

    // toString
    public function __toString() {
        $str = "
        Empresa: {$this->getNombre()}.\n
        Viajes: {$this->arrayViajesToString()}.\n";
        return $str;
    }
}