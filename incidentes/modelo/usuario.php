<?php
require_once 'funciones.php';
class Usuario{
    function existeUsuarioActivo($email){
        $instFunciones= new Funciones();
        
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM usuario WHERE email_usuario=:email and activo_usuario = 1");
        $consulta->bindParam(':email', $email);
        $consulta->execute();
        
        $datosUsuario = array();
        
        $row = $consulta->fetch(PDO::FETCH_ASSOC);
        if($row){
            $datosUsuario = $row;
        }

        return $datosUsuario; 
    }
    function existeUsuario($email){
        $instFunciones= new Funciones();
        
        $bd= $instFunciones->conectarBd();
        
        $consulta= $bd->prepare("SELECT * FROM usuario WHERE email_usuario=:email");
        $consulta->bindParam(':email', $email);
        $consulta->execute();
        
        $datosUsuario = array();
        
        $row = $consulta->fetch(PDO::FETCH_ASSOC);
        if($row){
            $datosUsuario = $row;
        }

        return $datosUsuario; 
    }
    function altaUsuario ($clave,$nombre,$apellido,$email){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $activo= 1;
        
        //preparar consulta de agregar 
        $consulta= $bd->prepare("INSERT INTO usuario (clave_usuario, nombre_usuario, apellido_usuario, email_usuario, activo_usuario) 
                                 VALUES (:clave,:nombre,:apellido,:email,:activo)");
        
        $consulta->bindParam(':clave', $clave);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':activo', $activo);
        
        //ejecuto la consulta
        return $consulta->execute();
    }
    
     function modificacionUsuario ($idUsuario,$nombre,$apellido,$email,$activo){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta de modificaion
        $consulta= $bd->prepare("UPDATE usuario SET nombre_usuario= :nombre,apellido_usuario= :apellido, email_usuario= :email, activo_usuario= :activo WHERE id_usuario= :idUsuario"); 
        
        $consulta->bindParam(':idUsuario', $idUsuario);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':activo', $activo);
        
        return $consulta->execute();
    }
    
      function  eliminarUsuario($idUsuario){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $activo= 0;
        
        //preparar consulta de eliminacion de un usuario
        $consulta= $bd->prepare("UPDATE usuario SET activo_usuario= :activo WHERE id_usuario= :idUsuario"); 
        
        $consulta->bindParam(':idUsuario', $idUsuario);
        $consulta->bindParam(':activo', $activo);
        
        return $consulta->execute();
    }
    
    function  listadoUsuarios() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta listado de todos los donantes
        $consulta= $bd->prepare("SELECT * FROM usuario"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $usuarios = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $usuarios[$index]=$row;
                    $index ++;
        }
        
        //retorno el arreglo
        return $usuarios;
    }
    
    function  listadoUsuariosActivos() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta listado de todos los usuarios
        $consulta= $bd->prepare("SELECT * FROM usuario WHERE activo_usuario = 1"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos 
        $usuarios = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $usuarios[$index]=$row;
                    $index ++;
        }
        
        //retorno el arreglo
        return $usuarios;
    }
    
    function  listadoUsuariosDesactivados() {
         //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta listado 
        $consulta= $bd->prepare("SELECT * FROM usuario WHERE activo_usuario = 0"); 
        
        $consulta->execute();
        
        //me guardo en un arreglo los datos
        $usuarios = array();
        $index=0;
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $usuarios[$index]=$row;
                    $index ++;
        }
        
        //retorno el arreglo
        return $usuarios;
    }
    
    function datosUsuarioConId($id){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        //preparar consulta obtener los datos
        $consulta= $bd->prepare("SELECT * FROM usuario WHERE id_usuario = :id"); 
        
        $consulta->bindParam(':id', $id);
        
        $consulta->execute();
        
        //me guardo los datos del usuario 
        $datosUsuario = $consulta->fetch(PDO::FETCH_ASSOC);
        
        //retorno los datos
        return $datosUsuario; 
    }
    
    function  activarUsuario($idUsuario){
        //conexion a la base de datos
        $instFunciones= new Funciones();
        $bd= $instFunciones->conectarBd();
        
        $activo= 1;
        
        //preparar consulta de eliminacion
        $consulta= $bd->prepare("UPDATE usuario SET activo_usuario= :activo WHERE id_usuario= :idUsuario"); 
        
        $consulta->bindParam(':idUsuario', $idUsuario);
        $consulta->bindParam(':activo', $activo);
        
        return $consulta->execute();
    }
    
    
}