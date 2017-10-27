<?php
require_once 'funciones.php';
class Incidente{
    function existeIncidente($nom){
        $instFunciones= new Funciones();
        
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM incidente WHERE nombre_incidente=:nombre");
        $consulta->bindParam(':nombre', $nom);
        $consulta->execute();
        
        $datos = array();
        
        $row = $consulta->fetch(PDO::FETCH_ASSOC);
        if($row){
            $datos = $row;
        }

        return $datos; 
    }
    function altaIncidente ($nombre){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de agregar 
        $consulta= $bd->prepare("INSERT INTO incidente (nombre_incidente) 
                                 VALUES (:nombre)");
        
        $consulta->bindParam(':nombre', $nombre);
        
        //ejecuto la consulta
        return $consulta->execute();
    }
    
     function modificacionIncidente ($id,$nombre){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de modificaion
        $consulta= $bd->prepare("UPDATE incidente SET nombre_incidente= :nombre WHERE id_incidente= :id"); 
        
        $consulta->bindParam(':id', $id);
        $consulta->bindParam(':nombre', $nombre);
        
        return $consulta->execute();
    }
    
//      function  eliminarIncidente($id){
//        //conexion a la base de datos
//        $instFunciones= new Funciones();
//        $bd= $instFunciones->conectarBd();
//        
//        $activo= 0;
//        
//        //preparar consulta de eliminacion 
//        $consulta= $bd->prepare("UPDATE tipo SET activo_tipo= :activo WHERE id_tipo= :id"); 
//        
//        $consulta->bindParam(':id', $id);
//        $consulta->bindParam(':activo', $activo);
//        
//        return $consulta->execute();
//    }
    
    function  listadoIncidentes() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM incidente"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $incidentes = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $incidentes[$index]=$row;
                    $index ++;
        }
        
        //retorno el arreglo
        return $incidentes;
    }
    

    function datosIncidenteConId($id){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta obtener los datos
        $consulta= $bd->prepare("SELECT * FROM incidente WHERE id_incidente = :id"); 
        
        $consulta->bindParam(':id', $id);
        
        $consulta->execute();
        
        //me guardo los datos 
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);
        
        //retorno los datos
        return $datos; 
    }
    
}