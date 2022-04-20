<?php

class Viaje {
    //Atributos
    private $codViaje; //int
    private $destino; //string
    private $cantPasajeros; //int
    private $cantMaxPasajeros; //int
    private $arrayPasajeros = []; //["Nombre"=>, "Apellido"=>, "DNI"=>]

    //Construct
    public function __construct($codViaje, $destino, $cantMaxPasajeros) {
        $this->codViaje = $codViaje;
        $this->destino = $destino;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    //Getters & Setters
    public function getCodViaje() {
        return $this->codViaje;
    }

    public function setCodViaje($codViaje) {
        $this->codViaje = $codViaje;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }

    public function getCantPasajeros() {
        return $this->cantPasajeros;
    }

    public function setCantPasajeros($cantPasajeros) {
        $this->cantPasajeros = $cantPasajeros;
    }

    public function getCantMaxPasajeros() {
        return $this->cantMaxPasajeros;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros) {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function getArrayPasajeros() {
        return $this->arrayPasajeros;
    }

    public function setArrayPasajeros($arrayPasajeros) {
        $this->arrayPasajeros = $arrayPasajeros;
    }

    /**
     * Función para agregar un pasajero
     * @param array $pasajero ["Nombre"=>, "Apellido"=>, "DNI"=>]
     * @return boolean
     */
    public function agregarPasajero($pasajero) {
        $bandera = false;
        $newArray = $this->getArrayPasajeros();
        if (in_array($pasajero, $this->getArrayPasajeros())) {
            $bandera = false;
        } else {
            array_push($newArray, $pasajero);
            $this->setArrayPasajeros($newArray);
            $bandera = true;
        }
        return $bandera;
    }

    /**
     * Función para conocer si existen lugares disponibles
     * @param void
     * @return boolean
     */
    public function lugarDisponible() {
        $bandera = true;
        if ($this->getCantMaxPasajeros() <= (count($this->getArrayPasajeros()))) {
            $bandera = false;
        }
        return $bandera;
    }

    /**
     * Función para borrar pasajero
     * @param array $pasajero
     * @return void
     */
    public function borrarPasajero($deletePasajero) {
        $pasajerosArr = $this->getArrayPasajeros();
        $i = 0;
        while( $i < count( $pasajerosArr ) && ( $pasajerosArr[$i] != $deletePasajero )) {
            $i = $i + 1;
        }
        if( $pasajerosArr[$i] == $deletePasajero ) {
            array_splice( $pasajerosArr, $i, 1);
        }
        $this->setArrayPasajeros( $pasajerosArr );
    }

    /**
     * Función para modificar datos de un pasajero 
     * @param array $pasajero
     * @param array $pasajeroMod
     * @return void
     */
    public function modDatos($pasajero, $pasajeroMod) {
        $arrPasajeros = $this->getArrayPasajeros();
        $i = 0;
        while( $i < count( $arrPasajeros ) && ( $arrPasajeros[$i] != $pasajero )) {
            $i = $i + 1;
        }
        if( $arrPasajeros[$i] == $pasajero ) {
            $arrPasajeros[$i] = $pasajeroMod;
        }
        $this->setArrayPasajeros($arrPasajeros);
    }

    /**
     * Función para desplegar datos de los pasajeros
     * @param void
     * @return string
     */
    public function strPasajeros() {
        $pasajerosStr = "";
        foreach ($this->getArrayPasajeros() as $a) {
            $nombre = $a["Nombre"];
            $apellido = $a["Apellido"];
            $dni = $a["DNI"];
            $pasajerosStr .= "
            Nombre: $nombre \n
            Apellido: $apellido \n
            DNI: $dni \n";
        }
        return $pasajerosStr;
    }

    //Función toString de datos del viaje
    public function __toString() {
        $pasajeros = $this->strPasajeros();
        $arrayPasajeros = $this->getArrayPasajeros();
        $cantidad = count($arrayPasajeros);
        $viaje = "
        Viaje: {$this->getCodViaje()} \n
        Destino: {$this->getDestino()} \n
        Cantidad de asientos: {$this->getCantMaxPasajeros()} \n
        Asientos ocupados: $cantidad \n
        Datos de pasajeros: \n $pasajeros";
        return $viaje; 
    }
}