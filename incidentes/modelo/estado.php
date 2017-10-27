<?php
require_once 'funciones.php';
class Estado{
    function altaEstado ($nom){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de agregar 
        $consulta= $bd->prepare("INSERT INTO estado (nombre_estado) 
                                 VALUES (:nom)");
        
        $consulta->bindParam(':nom', $nom);
         
        //ejecuto la consulta
        return $consulta->execute();
    }
    
     function modificacionEstado ($id,$nom){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de modificaion
        $consulta= $bd->prepare("UPDATE estado SET nombre_estado= :nom WHERE id_estado= :id"); 
        
        $consulta->bindParam(':id', $id);
        $consulta->bindParam(':nom', $nom);
        
        return $consulta->execute();
    }
    
    function  listadoEstados() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta listado 
        $consulta= $bd->prepare("SELECT * FROM estado"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $estados = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $estados[$index]=$row;
                    $index ++;
        }
        
        //retorno el arreglo
        return $estados;
    }
       
    function datosEstadoConId($id){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta obtener los datos
        $consulta= $bd->prepare("SELECT * FROM estado WHERE id_estado = :id"); 
        
        $consulta->bindParam(':id', $id);
        
        $consulta->execute();
        
        //me guardo los datos 
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);
        
        //retorno los datos
        return $datos; 
    }
    
}