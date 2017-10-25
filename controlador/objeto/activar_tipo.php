<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/tipo.php';
    
    if (isset($_POST['id'])) {
        //obtengo el id del tipo a activar
        $idTipo=$_POST['id'];
  
        $tipoInst= new Tipo();
    
        $mensajeOk=false;
        Try{  
               $tipoInst->activarTipo($idTipo);
               $mensajeOk=true;
        } 
        catch (PDOException $e) {
              $mensaje= 'ERROR: No se pudo activar el tipo. ' . $e->getMessage();
              $mensajeOk=false;
        }
        if($mensajeOk){
            $mensaje='Se activo el tipo con exito.';
        }
        else{
            $mensaje='No se ha podido activar el tipo.';
        }
        
        //active un tipo 
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
