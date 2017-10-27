<?php
require_once 'funciones.php';
class Expediente{
    
    function altaExpediente ($cliente,$incidente,$fecha,$cantidad,$descripcion,$estado){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de agregar 
        $consulta= $bd->prepare("INSERT INTO expediente (cliente_expediente, incidente_expediente, fecha_expediente, cantidad_expediente, descripcion_expediente, estado_expediente) 
                                 VALUES (:cliente,:incidente,:fecha,:cantidad,:descripcion,:estado)");
        
        $consulta->bindParam(':cliente', $cliente);
        $consulta->bindParam(':incidente', $incidente);
        $consulta->bindParam(':fecha', $fecha);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->bindParam(':descripcion', $descripcion);
        $consulta->bindParam(':estado', $estado);
        //ejecuto la consulta
        $consulta->execute();
        
        return $bd->lastInsertId();
    }
    
     function modificacionExpediente ($id,$cliente,$incidente,$fecha,$cantidad,$descripcion,$estado){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de modificaion
        $consulta= $bd->prepare("UPDATE expediente SET cliente_expediente= :cliente, incidente_expediente= :incidente, fecha_expediente= :fecha, cantidad_expediente= :cantidad, descripcion_expediente= :descripcion, estado_expediente= :estado WHERE id_producto= :id"); 
        
        $consulta->bindParam(':id', $id);
        $consulta->bindParam(':cliente', $cliente);
        $consulta->bindParam(':incidente', $incidente);
        $consulta->bindParam(':fecha', $fecha);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->bindParam(':descripcion', $descripcion);
        $consulta->bindParam(':estado', $estado);
        
        return $consulta->execute();
    }
    
    function  listadoExpedientes() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM expediente e INNER JOIN incidente i ON e.incidente_expediente = i.id_incidente INNER JOIN usuario u ON e.cliente_expediente = u.id_usuario INNER JOIN estado es ON e.estado_expediente = es.id_estado"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $expedientes = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $expedientes[$index]=$row;
            $expedientes[$index]['fecha_expediente']=date("d/m/Y",strtotime($expedientes[$index]['fecha_expediente']));
            $index ++;
        }
        
        //retorno el arreglo
        return $expedientes;
    }
    
    function  listadoExpedientesIniciados() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM expediente e INNER JOIN incidente i ON e.incidente_expediente = i.id_incidente INNER JOIN usuario u ON e.cliente_expediente = u.id_usuario INNER JOIN estado es ON e.estado_expediente = es.id_estado WHERE e.estado_expediente= 1"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $expedientes = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $expedientes[$index]=$row;
            $expedientes[$index]['fecha_expediente']=date("d/m/Y",strtotime($expedientes[$index]['fecha_expediente']));
            $index ++;
        }
        
        //retorno el arreglo
        return $expedientes;
    }
       
    function datosExpedienteConId($id){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta obtener los datos
        $consulta= $bd->prepare("SELECT * FROM expediente e INNER JOIN incidente i ON e.incidente_expediente = i.id_incidente INNER JOIN usuario u ON e.cliente_expediente = u.id_usuario INNER JOIN estado es ON e.estado_expediente = es.id_estado WHERE e.id_expediente = :id"); 
        
        $consulta->bindParam(':id', $id);
        
        $consulta->execute();
        
        //me guardo los datos del producto 
        $datosExpediente = $consulta->fetch(PDO::FETCH_ASSOC);
        
        //retorno los datos
        return $datosExpediente; 
    }
    
    function  listadoExpedientesDelCliente($cliente) {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM expediente e INNER JOIN incidente i ON e.incidente_expediente = i.id_incidente INNER JOIN usuario u ON e.cliente_expediente = u.id_usuario INNER JOIN estado es ON e.estado_expediente = es.id_estado WHERE e.cliente_expediente= :cliente"); 
        
        $consulta->bindParam(':cliente', $cliente);
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $expedientes = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $expedientes[$index]=$row;
            $expedientes[$index]['fecha_expediente']=date("d/m/Y",strtotime($expedientes[$index]['fecha_expediente']));
            $index ++;
        }
        
        //retorno el arreglo
        return $expedientes;
    }   
}