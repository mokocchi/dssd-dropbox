<?php
require_once 'funciones.php';
class Estado{
    function altaObjeto ($nom,$cant,$desc,$expe){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de agregar 
        $consulta= $bd->prepare("INSERT INTO objeto (nombre_objeto, cantidad_objeto, descripcion_objeto, expediente_objeto) 
                                 VALUES (:nom,:cant,:desc,:expe)");
        
        $consulta->bindParam(':nom', $nom);
        $consulta->bindParam(':cant', $cant);
        $consulta->bindParam(':desc', $desc);
        $consulta->bindParam(':expe', $expe);
        
        //ejecuto la consulta
        return $consulta->execute();
    }
    
     function modificacionObjeto ($id,$nom,$cant,$desc,$expe){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de modificaion
        $consulta= $bd->prepare("UPDATE objeto SET nombre_objeto= :nom, cantidad_objeto= :cant, descripcion_objeto= :desc, expediente_objeto= :expe WHERE id_objeto= :id"); 
        
        $consulta->bindParam(':id', $id);
        $consulta->bindParam(':nom', $nom);
        $consulta->bindParam(':cant', $cant);
        $consulta->bindParam(':desc', $desc);
        $consulta->bindParam(':expe', $expe);
        
        return $consulta->execute();
    }
    
    function  listadoObjetos() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta listado 
        $consulta= $bd->prepare("SELECT * FROM objeto"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $objetos = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $objetos[$index]=$row;
                    $index ++;
        }
        
        //retorno el arreglo
        return $objetos;
    }
    
    function  listadoObjetosDelExpediente($expe) {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM objeto WHERE expediente_objeto= :expe"); 
        
        $consulta->bindParam(':expe', $expe);
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $objetos = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $objetos[$index]=$row;
                    $index ++;
        }
        
        //retorno el arreglo
        return $objetos;
    }   
    
    function datosObjetoConId($id){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta obtener los datos
        $consulta= $bd->prepare("SELECT * FROM objeto WHERE id_objeto = :id"); 
        
        $consulta->bindParam(':id', $id);
        
        $consulta->execute();
        
        //me guardo los datos 
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);
        
        //retorno los datos
        return $datos; 
    }
    
}