<?php

class Viaje {
    // Atributos
    private $codViaje; //int
    private $destino; //string
    private $cantMaxPasajeros; //int
    private $arrayPasajeros = []; //["Nombre"=>, "Apellido"=>, "DNI"=>, "Telefono"=>]
    private $responsableViaje; //objeto de la clase ResponsableV

    // Constructor
    public function __construct( $codViaje, $destino, $cantMaxPasajeros, $responsableViaje ) {
        $this->codViaje = $codViaje;
        $this->destino = $destino;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->responsableViaje = $responsableViaje;
    }

    // Getters & Setters
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

    public function getResponsableViaje(){
        return $this->responsableViaje;
    }
    public function setResponsableViaje($responsableViaje){
        $this->responsableViaje = $responsableViaje;
    }
    
    /**
     * Método para verificar lugares disponibles en el viaje
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
     * Método para agregar un pasajero
     * @param object $objPasajero
     * @return boolean
     */
    public function agregarPasajero( $objPasajero ) {
        $bandera = false;
        $newArray = $this->getArrayPasajeros();
        $noEncontrado = true;
        $i = 0;

        $dniComparar = $objPasajero->getNumDNI();
        while( $noEncontrado && $i < count($newArray) ) {
            $pasajero = $newArray[$i];
            $dni = $pasajero->getNumDNI();
            if( $dni === $dniComparar ) {
                $noEncontrado = false;
            }
            $i++;
        }
        if( $noEncontrado ) {
            $bandera = true;
            if( count($newArray) == 0 ) {
                $newArray[0] = $objPasajero;
            }else {
                $newArray[count( $newArray )] = $objPasajero;
            }
            $this->setArrayPasajeros( $newArray );
        }else {
            $bandera = false;
        }
        return $bandera;
    }

    /**
     * Método que borra pasajero
     * @param int $dni
     * @return boolean
     */
    public function borrarPasajero( $dni ) {
        $bandera = false;
        $arrayPasajeros = $this->getArrayPasajeros();
        $i = 0;
        $posicion = 0;
        $noEncontrado = true;

        while( $noEncontrado || $i < count( $arrayPasajeros )) {
            $pasajero = $arrayPasajeros[$i];
            $dni = $pasajero->getNumDNI();
            if( $dni == $dni ) {
                $noEncontrado = false;
                $posicion = $i;
            }
            $i++;
        }
        if( !$noEncontrado ) {
            $arraySinPasajeros = [];
            foreach( $arrayPasajeros as $key => $value ) {
                if( $posicion != $key ) {
                    if( count($arraySinPasajeros) == 0 ) {
                        $arraySinPasajeros[0] = $value;
                    }else {
                        $arraySinPasajeros[count($arrayPasajeros)] = $value;
                    }
                }
            }
            $this->setArrayPasajeros( $arraySinPasajeros );
            $bandera = true;
        }else {
            $bandera = false;
        }
        return $bandera;
    }

    /**
     * Método que modifica datos de un pasajero 
     * @param int $dni
     * @return boolean
     */
    public function modDatos( $dni ) {
        $bandera = false;
        $arrayPasajeros = $this->getArrayPasajeros();
        $encontrado = false;
        $i = 0;
        $posicion = 0;

        while( $encontrado && $i < count($arrayPasajeros) ) {
            $pasajero = $arrayPasajeros[$i];
            $dni = $pasajero->getNumDNI();
            if( $dni == $dni ) {
                $encontrado = true;
                $posicion = $i;
                $bandera = true;
            }
            $i++;
        }
        if( !$encontrado ) {
            $objPasajero = $arrayPasajeros[$posicion];
            $this->modificarPasajero($objPasajero);
            $arrayPasajeros[$posicion] = $objPasajero;
        }
        return $bandera;
    }

    /**
     * Método que modifica un dato específico del pasajero
     * @param object $objPasajero
     * @return object
     */
    public function modificarPasajero( $objPasajero ) {
        $menuStr = "
        1. Modificar nombre\n
        2. Modificar apellido\n
        3. Modificar DNI\n
        4. Modificar teléfono\n
        5. Salir\n";
        do {
            echo $menuStr;
            $seleccion = trim(fgets(STDIN));
            switch( $seleccion ) {
                case 1:
                    echo "Ingrese el nuevo nombre: \n";
                    $nombreNuevo = trim(fgets(STDIN));
                    $objPasajero->setNombre( $nombreNuevo );
                    break;
                case 2:
                    echo "Ingrese el nuevo apellido: \n";
                    $apellidoNuevo = trim(fgets(STDIN));
                    $objPasajero->setApellido( $apellidoNuevo );
                    break;
                case 3:
                    echo "Ingrese el nuevo DNI: \n";
                    $dniNuevo = trim(fgets(STDIN));
                    $objPasajero->setNumDNI( $dniNuevo );
                    break;
                case 4:
                    echo "Ingrese el nuevo teléfono: \n";
                    $telefonoNuevo = trim(fgets(STDIN));
                    $objPasajero->setTelefono( $telefonoNuevo );
                    break;
            }
        } while ( $seleccion != 5);
        return $objPasajero;
    }

    /**
     * Método que despliega datos de los pasajeros
     * @param void
     * @return string
     */
    public function strPasajeros() {
        $pasajerosStr = "";
        foreach ( $this->getArrayPasajeros() as $key => $value ) {
            $objPasajero = $value;
            $str = $objPasajero->__toString();
            $pasajerosStr.= $str;
        }
        return $pasajerosStr;
    }
    
    // toString
    public function __toString() {
        $pasajeros = $this->strPasajeros();
        $arrayPasajeros = $this->getArrayPasajeros();
        $responsable = $this->getResponsableViaje();
        $toStringResponsable = $responsable->__toString();
        $cantidad = count($arrayPasajeros);
        $viaje = "
        Viaje: {$this->getCodViaje()} \n
        Destino: {$this->getDestino()} \n
        Cantidad de asientos: {$this->getCantMaxPasajeros()} \n
        Asientos ocupados: $cantidad \n
        Datos del responsable: \n $toStringResponsable \n
        Datos de pasajeros: \n $pasajeros";
        return $viaje; 
    }

}