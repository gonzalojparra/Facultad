<?php

class MasterController {

    public function comprobarMateria($usuario){
        $conn = new db();
        //busqueda en si
        $sql = "SELECT materia FROM profesor WHERE usuario = '$usuario'";
        $materiaDada = null;   
        if($conn->Iniciar()){
            $conn->Ejecutar($sql);
            if($row2 = $conn->Registro()){
                if($row2['materia'] != null && $row2['materia'] != ''){
                    $materiaDada = $row2['materia'];
                }
                
            }
        }
        $conn = null;
        return $materiaDada;
    }

    public function getSlashesImg() {
        if( isset($_POST) && count($_POST) >= 0 ){
            $imagen = $_FILES['foto']['tmp_name'];
            $foto = addslashes( file_get_contents($imagen) );
        }
        return $foto;
    }
}