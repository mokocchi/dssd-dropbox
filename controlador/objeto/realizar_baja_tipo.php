<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/tipo.php';
    
    if (isset($_POST['id'])) {
        //obtengo el id del tipo a borrar
        $idTipo=$_POST['id'];
  
        $tipoInst= new Tipo();
    
        $mensajeOk=false;
        Try{  
               $tipoInst->eliminarTipo($idTipo);
               $mensajeOk=true;
        } 
        catch (PDOException $e) {
              $mensaje= 'ERROR: ' . $e->getMessage();
              $mensajeOk=false;
        }
        if($mensajeOk){
            $mensaje='Se ha eliminado el tipo con exito.';
        }
        else{
            $mensaje='No se ha podido eliminar el tipo.';
        }
        
        //borre un tipo 
        $_SESSION['mensaje']=$mensaje;
        header ('Location: ./abm_tipo.php');
    }
    else{
        header ('Location: ../usuario/administrador.php');
    }
}
 else{
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }
