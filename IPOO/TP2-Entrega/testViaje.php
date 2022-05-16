<?php

require_once('Empresa.php');
require_once('Viaje.php');
require_once('Aereos.php');
require_once('Terrestres.php');
require_once('ResponsableV.php');
require_once('Pasajero.php');


// Instanciación de la empresa
$objEmpresa = new Empresa('Simuladores');
// Instanciación de los responsables
$objResponsable1 = new ResponsableV(1, 111, 'Mario', 'Santos');
$objResponsable2 = new ResponsableV(2, 112, 'Emilio', 'Ravenna');
// Instanciación de los viajes
$objViaje1 = new Aereos(1, 'Lima', 15, $objResponsable1, 1000, 'Ida y Vuelta', 11, 'Primera Clase', 'Cozzetti Airlines', 0);
$objViaje2 = new Aereos(2, 'Ottawa', 10, $objResponsable2, 2500, 'Ida', 20, 'Primera Clase', 'Cozzetti Airlines', 1);
$objViaje3 = new Terrestres(3, 'VLA', 20, $objResponsable1, 100, 'Ida y Vuelta', 'Cama');
// Instanciación de los pasajeros
$objPasajero1 = new Pasajero('Martín', 'Venegas', 20741963, 123);
$objPasajero2 = new Pasajero('José', 'Fehler', 5369147, 124);
$objPasajero3 = new Pasajero('Betún', 'Gaucho', 147, 125);


// Se almacena el arreglo de pasajeros en el viaje correspondiente
// Viaje 1
$arrPasajerosViaje1 = [$objPasajero1, $objPasajero2, $objPasajero3];
$objViaje1->setArrayPasajeros( $arrPasajerosViaje1 );
// Viaje 2
$arrPasajerosViaje2 = [$objPasajero3, $objPasajero1, $objPasajero2];
$objViaje2->setArrayPasajeros( $arrPasajerosViaje2 );
// Viaje 3
$arrPasajerosViaje3 = [$objPasajero2, $objPasajero3, $objPasajero1];
$objViaje3->setArrayPasajeros( $arrPasajerosViaje3 );

// Se almacena el arreglo de viajes en la empresa
$arrViajes = [$objViaje1, $objViaje2, $objViaje3];
$objEmpresa->setArrayViajes( $arrViajes );


/**
 * Método para ingresar datos de un pasajero
 * @param void
 * @return object
 */
function ingresarDatos() {
    echo "Nombre: ";
    $nombre = trim(fgets(STDIN));
    echo "Apellido: ";
    $apellido = trim(fgets(STDIN));
    echo "DNI: ";
    $dni = trim(fgets(STDIN));
    echo "Telefono: ";
    $telefono = trim(fgets(STDIN));
    $pasajero = new Pasajero( $nombre, $apellido, $dni, $telefono);
    return $pasajero;
}

/** 
* Método para seleccionar opción de la función 'viaje'
* @param void
* @return string
*/
function seleccionarOpcion() {
    $opcion = "MENU DE VIAJE FELIZ\n
    1) Modificar el código del viaje. \n
    2) Modificar el destino del viaje. \n
    3) Modificar la cantidad de asientos del viaje. \n
    4) Agregar pasajero. \n
    5) Quitar pasajero. \n
    6) Modificar pasajero. \n
    7) Modificar datos del responsable. \n
    8) Ver datos del responsable. \n
    9) Ver viaje. \n
    10) Salir. \n
    Seleccione la opción deseada: ";
    return $opcion;
}

/**
 * Método que realiza operaciones de viajes
 * @param object $objViaje
 * @return object
 */
function viaje( $objViaje ) {
    do {
        // Se muestra por pantalla el menú de opciones
        echo seleccionarOpcion();
        $seleccion = trim(fgets(STDIN));
        switch ($seleccion) {
            case 1:
                // Modificar código del viaje
                echo "El código del viaje es: {$objViaje->getCodViaje()}\n";
                echo "Ingrese el código nuevo: ";
                $codigo = trim(fgets(STDIN));
                echo "\n"; // Salto de línea para mayor legibilidad
                $objViaje->setCodViaje($codigo);
                break;
            case 2:
                // Modificar el destino del viaje
                echo "El destino actual del viaje es: {$objViaje->getDestino()}\n";
                echo "Ingrese el nuevo destino: ";
                $destino = trim(fgets(STDIN));
                echo "\n"; // Salto de línea para mayor legibilidad
                $objViaje->setDestino($destino);
                break;
            case 3:
                // Modificar la cantidad de asientos del viaje
                echo "El viaje posee {$objViaje->getCantMaxPasajeros()} asientos. \n";
                echo "Ingrese la cantidad nueva de asientos: ";
                $cantAsientos = trim(fgets(STDIN));
                echo "\n"; // Salto de línea para mayor legibilidad
                $objViaje->setCantMaxPasajeros($cantAsientos);
                break;
            case 4:
                // Agregar pasajero
                if($objViaje->lugarDisponible()) {
                    echo "Ingrese los datos del pasajero: \n";
                    $objPasajero = ingresarDatos();
                    if($objViaje->agregarPasajero($objPasajero)) {
                        echo "Pasajero agregado.\n";
                    } else {
                        echo "El pasajero ya se encuentra registrado.\n";
                    }
                } else {
                    echo "No quedan lugares disponibles.\n";
                }
                break;
            case 5:
                // Quitar pasajero
                echo "Ingrese el DNI del pasajero a quitar: \n";
                $dni = trim(fgets(STDIN));
                if( $objViaje->borrarPasajero($dni) ) {
                    echo "El pasajero ha sido eliminado del viaje.\n";
                } else {
                    echo "No se ha encontrado al pasajero ingresado.\n";
                }
                break;
            case 6:
                // Modificar pasajero
                echo "Ingrese el DNI del pasajero a modificar: \n";
                $dni = trim(fgets(STDIN));
                if ( $objViaje->modDatos($dni) ) {
                    echo "Los datos han sido modificados con éxito.\n";
                } else {
                    echo "No se ha encontrado al pasajero ingresado.\n";
                }
                break;
            case 7:
                // Modificar datos del responsable del viaje
                echo "Ingrese los datos del nuevo responsable: \n";
                echo "Numero de empleado: \n";
                $numEmpleado = trim(fgets(STDIN));
                echo "Numero de licencia: \n";
                $numLicencia = trim(fgets(STDIN));
                echo "Nombre: \n";
                $nombre = trim(fgets(STDIN));
                echo "Apellido: \n";
                $apellido = trim(fgets(STDIN));
                $objResponsable = new ResponsableV( $numEmpleado, $numLicencia, $nombre, $apellido );
                $objViaje->setResponsableViaje( $objResponsable );
                break;
            case 8:
                // Ver datos del responsable del viaje
                $datos = $objViaje->getResponsableViaje();
                echo $datos;
                break;
            case 9:
                // Ver viaje
                echo $objViaje;
                break;
        }
    } while ($seleccion != 10);
    return $objViaje;
}

/**
 * Método que despliega el menú de opciones
 * @param void
 * @return string
 */
function menu() {
    $str = "¡Viaje Feliz!\nPor favor seleccione una opción:
    ----------------------------------------\n
    1. Ver datos de la empresa.\n
    2. Modificar atributos de un viaje.\n
    3. Vender un pasaje.\n
    4. Salir.\n";
    return $str;
}

// Proceso
do {
    echo menu();
    $seleccion = trim(fgets(STDIN));
    switch( $seleccion ) {
        case 1:
            echo $objEmpresa->__toString();
            break;
        case 2:
            echo "Coloque el número de viaje que desea modificar: ";
            $viajeTrim = trim(fgets(STDIN));
            $posicion = $objEmpresa->buscarViaje( $viajeTrim );
            if( $posicion >= 0) {
                $viajeArr = $objEmpresa->getArrayViajes();
                $objViaje = $viajeArr[$posicion];
                $viajeArr[$posicion] = viaje( $objViaje );
                $objEmpresa->setArrayViajes( $viajeArr );
            }
            break;
        case 3:
            echo "Ingrese los datos del pasajero: \n";
            $objPasajero = ingresarDatos();
            $importe = $objEmpresa->venderPasaje( $objPasajero );
            if( $importe != null ) {
                echo "El importe es $ {$importe}.\n";
            } else {
                echo "La transacción no se ha podido realizar correctamente.\n";
            }
            break;
    }
} while ( $seleccion != 4 );