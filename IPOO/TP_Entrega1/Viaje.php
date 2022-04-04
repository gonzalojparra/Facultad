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
     * @return boolean
     */
    public function borrarPasajero($pasajero) {
        $bandera = false;
        $arrayBusqueda = $this->getArrayPasajeros();
        if (in_array($pasajero, $arrayBusqueda)) { // Se comprueba si existe el valor $pasajero en $arrayBusqueda
            $key = array_search($pasajero, $arrayBusqueda); // Se busca el valor $pasajero en $arrayBusqueda, si el valor existe devuelve la primera clave
            array_splice($arrayBusqueda, $key, 1); // Elimina una parte de $arrayBusqueda y la reemplaza por $key con length = 1
            $this->setArrayPasajeros($arrayBusqueda);
            $bandera = true;
        }
        return $bandera;
    }

    /**
     * Función para modificar datos de un pasajero 
     * @param array $pasajero
     * @param array $pasajeroMod
     * @return boolean
     */
    public function modDatos($pasajero, $pasajeroMod) {
        $bandera = false;
        $arrayMod = $this->getArrayPasajeros();
        if (in_array($pasajero, $arrayMod)) { // Se comprueba si existe el valor $pasajero en $arrayMod
            $key = array_search($pasajero, $arrayMod); // Se busca el valor $pasajero en $arrayMod, si el valor existe devuelve la primera clave
            $arrayMod[$key] = $pasajeroMod;
            $this->setArrayPasajeros($arrayMod);
            $bandera = true;
        }
        return $bandera;
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