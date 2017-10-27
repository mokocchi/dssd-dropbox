<?php
class Funciones {
    //conexion a la base de datos
    function conectarBd (){
        $dns= 'mysql:dbname=dssd_bd;host=localhost';
        $usuario= 'root';
        $clave= '';
        
        return new PDO($dns,$usuario,$clave);
    }
    
    function desconectar($db){
        $db->disconnect();
    }
    
}
