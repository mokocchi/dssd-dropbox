<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/usuario.php';
    
    if (isset($_POST['id'])) {
        //obtengo el id del usuario a activar
        $idUsuario=$_POST['id'];
  
        $usuarioInst= new Usuario();
    
        $mensajeOk=false;
        Try{  
               $usuarioInst->activarUsuario($idUsuario);
               $mensajeOk=true;
        } 
        catch (PDOException $e) {
              $mensaje= 'ERROR: No se pudo activar el usuario. ' . $e->getMessage();
              $mensajeOk=false;
        }
        if($mensajeOk){
            $mensaje='Se activo el usuario con exito.';
        }
        else{
            $mensaje='No se ha podido activar el usuario.';
        }
        
        //active un usuario 
        $_SESSION['mensaje']=$mensaje;
        header ('Location: ./abm_usuario.php');
    }
    else{
        header ('Location: ../usuario/administrador.php');
    }
}
 else{
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }
