<?php
require_once('ORM/BaseDatos.php');
require_once('ORM/Empresa.php');
require_once('ORM/Responsable.php');
require_once('ORM/Viaje.php');
require_once('ORM/Pasajero.php');


// Creación de base de datos
$bd = new BaseDatos();
$conexion = $bd->Iniciar();
if( $conexion ){
    echo "Conexión con la base de datos establecida\n";
} else {
    echo "No se pudo establecer conexión con la base de datos.\n";
    echo $bd->getError();
}


// Proceso
do {
    $objEmpresa = new Empresa();
    $objResponsable = new Responsable();
    $objViaje = new Viaje();
    $objPasajero = new Pasajero();
    echo menu();
    $selec = trim(fgets(STDIN));
    switch( $selec ){
        case 1:
            $arrayEmpresas = $objEmpresa->listar();
            if( count($arrayEmpresas) > 0 ){
                echo arrayString( $arrayEmpresas );
            } else {
                echo "No existen empresas registradas.\n";
            }
            break;
        case 2:
            $arrayResponsables = $objResponsable->listar();
            if( count($arrayResponsables) > 0 ){
                echo arrayString( $arrayResponsables );
            } else {
                echo "No existen responsables registrados.\n";
            }
            break;
        case 3:
            $arrayPasajeros = $objPasajero->listar();
            if( count($arrayPasajeros) > 0 ){
                echo arrayString( $arrayPasajeros );
                } else {
                    echo "No existen pasajeros registrados.\n";
                }
            break;
        case 4:
            $arrayViajes = $objViaje->listar();
            if( count($arrayViajes) > 0 ){
                echo arrayString( $arrayViajes );
            } else {
                echo "No existen viajes registrados.\n";
            }
            break;
        case 5:
                echo selecOpcion();
                $opcion = trim(fgets(STDIN));
                switch( $opcion ){
                    case 1:
                        echo "Ingrese nombre de empresa: \n";
                        $nombre = trim(fgets(STDIN));
                        if( $nombre !== '' ){
                            echo "Ingrese dirección de empresa: \n";
                            $direcc = trim(fgets(STDIN));
                            $objEmpresa->cargar(0, $nombre, $direcc);
                            if( $objEmpresa->insertar() ){
                                echo "Se insertó la empresa.\n";
                            } else {
                                echo "No se insertó la empresa.\n";
                                echo $objEmpresa->getMensajeOperacion();
                            }
                        } else {
                            echo "Por favor ingrese un nombre válido.\n";
                        }
                        break;
                    case 2:
                        echo "Ingrese el ID de la empresa a modificar: ";
                        $id = trim(fgets(STDIN));
                        if( $objEmpresa->buscar($id) ){
                            echo "Ingrese el nuevo nombre: \n";
                            $nombre = trim(fgets(STDIN));
                            echo "Ingrese la nueva dirección: \n";
                            $direcc = trim(fgets(STDIN));
                            $objEmpresa->cargar($id, $nombre, $direcc);
                            if( $objEmpresa->modificar() ){
                                echo "Se modificó la empresa.\n";
                            } else {
                                echo "No se modificó la empresa.\n";
                                echo $objEmpresa->getMensajeOperacion();
                            }
                        } else {
                            echo "La empresa con el id $id no existe.\n";
                        }
                        break;
                    case 3:
                        echo "Ingrese el ID de la empresa a eliminar: ";
                        $id = trim(fgets(STDIN));
                        if( $objEmpresa->buscar($id) ){
                            if( $objEmpresa->eliminar() ){
                                echo "Se borró la empresa.\n";
                            } else {
                                echo "No se borró la empresa.\n";
                                echo $objEmpresa->getMensajeOperacion();
                            }
                        } else {
                            echo "La empresa con el ID $id no existe.\n";
                        }
                        break;
                    case 4:
                        echo "Ingrese numero de licencia: ";
                        $numLicencia = trim(fgets(STDIN));
                        echo "Ingrese nombre: ";
                        $name = trim(fgets(STDIN));
                        echo "Ingrese apellido: ";
                        $apellido = trim(fgets(STDIN));
                        $objResponsable->cargar(0, $numLicencia, $name, $apellido);
                        if( $objResponsable->insertar() ){
                            echo "Se insertó el responsable.\n";
                        } else {
                            echo "No se insertó el responsable.\n";
                            echo $objResponsable->getMensajeOperacion();
                        }
                        break;
                    case 5:
                        echo "Ingrese el numero de empleado a modificar: ";
                        $numEmpleado = trim(fgets(STDIN));
                        if( $objResponsable->buscar($numEmpleado) ){
                            echo "Ingrese numero de licencia: ";
                            $numLicencia = trim(fgets(STDIN));
                            echo "Ingrese nombre: ";
                            $name = trim(fgets(STDIN));
                            echo "Ingrese apellido: ";
                            $apellido = trim(fgets(STDIN));
                            $objResponsable->cargar($numEmpleado, $numLicencia, $name, $apellido);
                            if( $objResponsable->modificar() ){
                                echo "Se modificó el responsable.\n";
                            } else {
                                echo "No se modificó el responsable.\n";
                                echo $objEmpresa->getMensajeOperacion();
                            }
                        } else {
                            echo "El responsable con el número $numEmpleado no existe.\n";
                        }
                        break;
                    case 6:
                        echo "Ingrese el numero de empleado a eliminar: ";
                        $numEmpleado = trim(fgets(STDIN));
                        if( $objResponsable->buscar($numEmpleado) ){
                            if( $objResponsable->eliminar() ){
                                echo "Se borró el responsable.\n";
                            } else {
                                echo "No se borró el responsable.\n";
                                echo $objEmpresa->getMensajeOperacion();
                            }
                        } else {
                            echo "El responsable con el número $numEmpleado no existe.\n";
                        }
                        break;
                    case 7:
                        echo "Ingrese el destino: ";
                        $destino = trim(fgets(STDIN));
                        $arrayDestinos = $objViaje->listar("vdestino = '{$destino}'");
                        if( count($arrayDestinos) === 0 ){
                            echo "Ingrese cantidad máxima de pasajeros: ";
                            $cantMaxPsj = trim(fgets(STDIN));

                            echo "Ingrese el ID de la empresa a cargo: ";
                            $idEmpresa = trim(fgets(STDIN));
                            $objEmpresa = new Empresa();
                            $objEmpresa->buscar($idEmpresa);
        
                            echo "Ingrese el numero de empleado del responsable a cargo: ";
                            $numEmpleadoRsp = trim(fgets(STDIN));
                            $objResponsable = new Responsable();
                            $objResponsable->buscar($numEmpleadoRsp);

                            echo "Ingrese el importe: ";
                            $importe = trim(fgets(STDIN));
                            echo "Ingrese tipo de asiento (Semi-cama o Cama): ";
                            $asiento = trim(fgets(STDIN));
                            echo "Ingrese si el viaje es de Ida y vuelta (Si o No): ";
                            $idavuelta = trim(fgets(STDIN));
                            $objViaje->cargar(0, $destino, $cantMaxPsj, $objEmpresa, $objResponsable, $importe, $asiento, $idavuelta);
                            // echo $objViaje->__toString();
                            if( $objViaje->insertar() ){
                                echo "Se insertó el viaje.\n";
                            } else {
                                echo "No se insertó el viaje.\n";
                                echo $objViaje->getMensajeOperacion();
                            }
                        } else {
                            echo "El viaje con el destino a $destino ya existe.\n";
                        }
                        break;
                    case 8:
                        echo "Ingrese el ID del viaje a modificar: ";
                        $id = trim(fgets(STDIN));
                        if( $objViaje->buscar($id) ){
                            echo "Ingrese el nuevo destino: ";
                            $destino = trim(fgets(STDIN));
                            echo "Ingrese nueva cantidad máxima de pasajeros: ";
                            $cantMaxPsj = trim(fgets(STDIN));

                            echo "Ingrese el ID de la empresa a cargo: ";
                            $idEmpresa = trim(fgets(STDIN));
                            $objEmpresa = new Empresa();
                            $objEmpresa->buscar($idEmpresa);

                            echo "Ingrese el numero de empleado del responsable a cargo: ";
                            $numEmpleadoRsp = trim(fgets(STDIN));
                            $objResponsable = new Responsable();
                            $objResponsable->buscar($numEmpleadoRsp);

                            echo "Ingrese nuevo importe: ";
                            $importe = trim(fgets(STDIN));
                            echo "Ingrese tipo de asiento (Semi-cama o Cama): ";
                            $asiento = trim(fgets(STDIN));
                            echo "Ingrese si el viaje es de Ida y vuelta (Si o No): ";
                            $idavuelta = trim(fgets(STDIN));
                            $objViaje->cargar($id, $destino, $cantMaxPsj, $objEmpresa, $objResponsable, $importe, $asiento, $idavuelta);
                            if( $objViaje->modificar() ){
                                echo "Se modificó el viaje.\n";
                            } else {
                                echo "No se modificó el viaje.\n";
                                echo $objViaje->getMensajeOperacion();
                            }
                        } else {
                            echo "El viaje con el id $id no existe.\n";
                        }
                        break;
                    case 9:
                        echo "Ingrese el ID de viaje a eliminar: ";
                        $id = trim(fgets(STDIN));
                        if( $objViaje->buscar($id) ){
                            if( $objViaje->eliminar() ){
                                echo "Se borró el viaje.\n";
                            } else {
                                echo "No se borró el viaje.\n";
                                echo $objViaje->getMensajeOperacion();
                            }
                        } else {
                            echo "El viaje con el id $id no existe.\n";
                        }
                        break;
                    case 10:
                        echo "Ingrese el documento del pasajero: ";
                        $documento = trim(fgets(STDIN));
                        if( $objPasajero->buscar($documento) ){
                            echo "El pasajero con el DNI $documento ya existe.\n";
                        } else {
                            echo "Ingrese el nombre: ";
                            $nombre = trim(fgets(STDIN));
                            echo "Ingrese el apellido: ";
                            $apellido = trim(fgets(STDIN));
                            echo "Telefono: ";
                            $telefono = trim(fgets(STDIN));

                            echo "Ingrese el ID del viaje: ";
                            $idviaje = trim(fgets(STDIN));
                            $objViaje = new Viaje();
                            $objViaje->buscar($idviaje);

                            $objPasajero->cargar( $documento, $nombre, $apellido, $telefono, $objViaje );
                            if( $objPasajero->insertar() ){
                                echo "Se insertó el pasajero.\n";
                            } else {
                                echo "No se insertó el pasajero.\n";
                                echo $objPasajero->getMensajeOperacion();
                            }
                        }
                        break;
                    case 11:
                        echo "Ingrese el documento del pasajero a modificar: ";
                        $documento = trim(fgets(STDIN));
                        if( $objPasajero->buscar($documento) ){
                            echo "Ingrese el nuevo nombre: ";
                            $nombre = trim(fgets(STDIN));
                            echo "Ingrese el nuevo apellido: ";
                            $apellido = trim(fgets(STDIN));
                            echo "Telefono: ";
                            $telefono = trim(fgets(STDIN));

                            echo "Ingrese el ID del viaje: ";
                            $idviaje = trim(fgets(STDIN));
                            $objViaje = new Viaje();
                            $objViaje->buscar($idviaje);

                            $objPasajero->cargar( $documento, $nombre, $apellido, $telefono, $objViaje );
                            if( $objPasajero->modificar() ){
                                echo "Se modificó el pasajero.\n";
                            } else {
                                echo "No se modificó el pasajero.\n";
                                echo $objPasajero->getMensajeOperacion();
                            }
                        } else {
                            echo "El pasajero con el documento $documento no existe.\n";
                        }
                        break;
                    case 12:
                        echo "Ingrese el documento del pasajero a eliminar: ";
                        $documento = trim(fgets(STDIN));
                        if( $objPasajero->buscar($documento) ) {
                            if( $objPasajero->eliminar() ){
                                echo "Se borró el pasajero.\n";
                            } else {
                                echo "No se borró el pasajero.\n";
                                echo $objPasajero->getMensajeOperacion();
                            }
                        } else {
                            echo "El pasajero con el documento $documento no existe.\n";
                        }
                        break;
        }
    }
} while ( $selec != 6 );

/**
 * Método que muestra opciones del menú principal
 * @param void
 * @return string
 */
function menu() {
    $str = "
    Por favor seleccione una opción:
    -----------------------------------\n
    1. Ver todas las empresas.\n
    2. Ver todos los responsables.\n
    3. Ver todos los pasajeros.\n
    4. Ver todos los viajes.\n
    5. Modificar base de datos.\n
    6. Salir.\n
    Ingrese una opción: ";
    return $str;
}

/**
 * Método que muestra opciones de la opción 2 del menú principal
 * @param void
 * @return string
 */
function selecOpcion() {
    $opcion = "
    ATENCIÓN! MODIFICARÁ LA BASE DE DATOS, PROCEDA CON PRECAUCIÓN\n
    ----------------------------------------\n
    1. CREAR una empresa.\n
    2. MODIFICAR una empresa.\n
    3. ELIMINAR una empresa.\n
    4. AGREGAR un responsable.\n
    5. MODIFICAR un responsable.\n
    6. ELIMINAR un responsable.\n
    7. CREAR un viaje.\n
    8. MODIFICAR un viaje.\n
    9. ELIMINAR un viaje.\n
    10. AGREGAR un pasajero.\n
    11. MODIFICAR un pasajero.\n
    12. ELIMINAR un pasajero.\n
    13. Salir.\n
    Ingrese una opción: ";
    return $opcion;
}

/**
 * Método que convierte arrays u objetos en cadenas de texto
 */
function arrayString( $array ){
    $str = "";
    foreach( $array as $key => $value ){
        $obj = $value;
        $strObj = $obj->__toString();
        $str.= "
        $strObj
        --------------------\n";
    }
    return $str;
}