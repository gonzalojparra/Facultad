<?php

class Empresa {
    // Atributos
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeOperacion;

    // Constructor
    public function __construct(){
        $this->idempresa = '';
        $this->enombre = '';
        $this->edireccion = '';
        $this->mensajeOperacion = '';
    }

    // Getters & Setters
    public function getIdempresa(){
        return $this->idempresa;
    }
    public function setIdempresa($idempresa){
        $this->idempresa = $idempresa;
    }

    public function getEnombre(){
        return $this->enombre;
    }
    public function setEnombre($enombre){
        $this->enombre = $enombre;
    }

    public function getEdireccion(){
        return $this->edireccion;
    }
    public function setEdireccion($edireccion){
        $this->edireccion = $edireccion;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    /**
    * Método que realiza los set de los atributos
    */
    public function cargar( $idempresa, $enombre, $edireccion ){
        $this->setIdempresa( $idempresa );
        $this->setENombre( $enombre );
        $this->setEdireccion( $edireccion );
    }

    /**
     * Método que busca y devuelve datos de la empresa
     * @param int $id
     * @return boolean $bandera
     */
    public function buscar( $id ){
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM empresa WHERE idempresa = " .$id;
        $bandera = false;

        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){
                if( $row2 = $bd->Registro() ){
                    $this->setIdempresa( $id );
                    $this->setEnombre( $row2['enombre'] );
                    $this->setEdireccion( $row2['edireccion'] );
                    $bandera = true;
                }
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $bandera;
    }

    /**
     * Método que lista todas las empresas con la condición recibida
     * Retorna un arreglo con los datos de las empresas
     * @param string $condicion
     * @return array
    */
    public function listar( $condicion = '' ){
        $arregloEmpresa = null;
        $bd = new BaseDatos();
        $consulta = "SELECT * FROM empresa";

        // Si la condición no está vacia, se arma un nuevo string para la consulta
        if( $condicion != '' ){
            $consulta = $consulta. ' WHERE ' .$condicion;
        }
        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($consulta) ){				
                $arregloEmpresa = array();
                while( $row2 = $bd->Registro() ){
                    $idempresa = $row2['idempresa'];
                    $enombre = $row2['enombre'];
                    $edireccion = $row2['edireccion'];

                    // Creo instancia donde se almacenarán los datos, para luego pushearlos en el array
                    $empresa = new Empresa();
                    $empresa->cargar( $idempresa, $enombre, $edireccion );
                    array_push( $arregloEmpresa, $empresa );
                }
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $arregloEmpresa;
    }

    public function insertar() {
        $bd = new BaseDatos();
        $bandera = false;
        $insert = "INSERT INTO empresa VALUES({$this->getIdempresa()}, '{$this->getEnombre()}', '{$this->getEdireccion()}')";

        if( $bd->Iniciar() ){
            if( $bd->Ejecutar($insert) ){
                $bandera = true;
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $bandera;
    }

    /**
     * Método que modifica los valores de una tupla de la tabla empresa
     * @param void
     * @return boolean
     */
    public function modificar() {
        $bd = new BaseDatos();
        $bandera = false;
        $modificar = "UPDATE empresa SET enombre = '{$this->getEnombre()}', edireccion = '{$this->getEdireccion()}' WHERE idempresa = {$this->getIdempresa()}";
        if( $bd->Iniciar() ){
            if(  $bd->Ejecutar($modificar) ){
                $bandera = true;
            } else {
                $this->setMensajeOperacion( $bd->getError() );
            }
        } else {
            $this->setMensajeOperacion( $bd->getError() );
        }
        return $bandera;
    }

    /**
     * Método que elimina una tupla según el id de la empresa
     * @param void
     * @return boolean
     */
    public function eliminar(){
		$bd = new BaseDatos();
		$bandera = false;
        $consulta = "DELETE FROM empresa WHERE idempresa = {$this->getIdempresa()}";
		if( $bd->Iniciar() ){
			if( $bd->Ejecutar($consulta) ){
			    $bandera = true;
			} else {
				$this->setmensajeoperacion( $bd->getError() );
			}
		} else {
            $this->setmensajeoperacion( $bd->getError() );
		}
		return $bandera; 
	}

    // toString
    public function __toString(){
        $str = "
        Empresa: {$this->getIdempresa()}.\n
        Nombre: {$this->getEnombre()}.\n
        Dirección: {$this->getEdireccion()}.\n";
        return $str;
    }

}
