<?php

require_once("Viaje.php");
echo "
¡Viaje Feliz!\n
Por favor complete el siguiente campo de datos: \n
----------------------------------------\n
Ingrese el código del viaje: ";
$codigoViaje = trim(fgets(STDIN));
echo "Ingrese el destino: ";
$destinoViaje = trim(fgets(STDIN));
echo "Ingrese la cantidad máxima de asientos: ";
$cantMaxAsientos = trim(fgets(STDIN));
echo "\n"; // Salto de línea para mayor legibilidad

$objViaje = new Viaje($codigoViaje, $destinoViaje, $cantMaxAsientos);

/**
* Función para seleccionar opción en el programa testViaje.php
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
7) Ver viaje. \n
8) Salir. \n
Seleccione la opción deseada: ";
    return $opcion;
}

/**
 * Función para ingresar datos de un pasajero
 * @param void
 * @return array
 */
function ingresarDatos() {
    echo "Nombre: \n";
    $nombre = trim(fgets(STDIN));
    echo "Apellido: \n";
    $apellido = trim(fgets(STDIN));
    echo "DNI: \n";
    $dni = trim(fgets(STDIN));
    $pasajero = ["Nombre"=>$nombre, "Apellido"=>$apellido, "DNI"=>$dni];
    return $pasajero;
}

//Proceso:
do {
    echo seleccionarOpcion(); // Se muestra por pantalla el menú de opciones
    $seleccion = trim(fgets(STDIN));
    switch ($seleccion) { // Se utiliza switch para el menú selector, la función sirve para comparar una misma variable con distintos valores (1, 2, 3, etc.)
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
                $pasajero = ingresarDatos();
                if($objViaje->agregarPasajero($pasajero)) {
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
            echo "Ingrese los datos del pasajero a quitar: \n";
            $pasajero = ingresarDatos();
            if($objViaje->borrarPasajero($pasajero)) {
                echo "El pasajero ha sido eliminado del viaje.\n";
            } else {
                echo "No se ha encontrado al pasajero ingresado.\n";
            }
            break;
        case 6:
            // Modificar pasajero
            echo "Ingrese los datos del pasajero a modificar: \n";
            $pasajero = ingresarDatos();
            echo "Ingrese los nuevos datos: \n";
            $pasajeroMod = ingresarDatos();
            if ($objViaje->modDatos($pasajero, $pasajeroMod)) {
                echo "Los datos han sido modificados con éxito.\n";
            } else {
                echo "No se ha encontrado al pasajero ingresado.\n";
            }
            break;
        case 7:
            // Ver viaje
            echo $objViaje;
            break;
    }
} while ($seleccion != 8);