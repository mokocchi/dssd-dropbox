<?php 
if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/usuario.php';
    require_once '../validador.php';
    
    if (isset($_POST['apellido']) && isset($_POST['activo']) && isset($_POST['nombre'])&&isset($_POST['idUsuario'])&& isset($_POST['email'])&& isset($_POST['emailOriginal'])){
 
        //obtengo los datos para modificar
        $ape=$_POST['apellido'];
        $nom=$_POST['nombre'];
        $email=$_POST['email'];
        $emailOriginal=$_POST['emailOriginal'];
        $id=$_POST['idUsuario'];
        $activo=$_POST['activo'];
    
        //agrego los datos
        $usuarioInst= new Usuario();
    
        //controlo los datos que vienen por post y si esta ok doy la modificacion
        $mensajeOk=false;
        if(($ape !='')&&($nom !='')&&($id !='')&&($activo !='')&&($email !='')&&($emailOriginal !='')){
	    $nom=trim($nom);
            $arreglo_nombre=array ('valor'=> $nom,'tipo' => 'Nombre', 'error'=> false, 'mensajeError' => '');
	    $ape=trim($ape);
            $arreglo_apellido=array ('valor'=> $ape,'tipo' => 'Apellido', 'error'=> false, 'mensajeError' => '');
	    $email=trim($email);
            $arreglo_email=array ('valor'=> $email,'tipo' => 'mail', 'error'=> false, 'mensajeError' => '');
            
            $patron = '/^[a-zA-Z\s]*$/';
            if (preg_match($patron, $arreglo_nombre['valor'])) {
                $arreglo_nombre['error'] = false;
            } else {
                $arreglo_nombre['error'] = true;
                $arreglo_nombre['mensajeError'] = $arreglo_nombre['tipo'] . ": debe contener solo letras.";
            }
            
            if (preg_match($patron, $arreglo_apellido['valor'])) {
                $arreglo_apellido['error'] = false;
            } else {
                $arreglo_apellido['error'] = true;
                $arreglo_apellido['mensajeError'] = $arreglo_apellido['tipo'] . ": debe contener solo letras.";
            }
            
            $parametros= validarCampos (array ($arreglo_nombre,$arreglo_apellido,$arreglo_email));
            
            if($parametros[0]['error']!==true &&($parametros[1]['error']!==true)&&
            ($parametros[2]['error']!==true)){
                $usuarioExiste=$usuarioInst->existeUsuario($email);
                if((count($usuarioExiste) == 0)||($email == $emailOriginal)){
                    Try{  
                        $usuarioInst->modificacionUsuario($id,$nom,$ape,$email,$activo);
                        $mensajeOk=true;
                    } 
                    catch (PDOException $e) {
                        $mensaje= 'ERROR: No se pudo modificar el usuario.' . $e->getMessage();
                        $mensajeOk=false;
                    }
                }
                else{
                    $mensaje="El e-mail de usuario ya existe.";
                }
            }
            else{
                $mensaje="Los siguientes campos no son correctos: " . $parametros[0]['mensajeError']." "
                       . $parametros[1]['mensajeError']." ". $parametros[2]['mensajeError']; 
            }    
        }
        else{
            $mensaje='Debe completar todos los campos.';
        }
        if($mensajeOk){
            $mensaje='Se han modificado los datos con exito.';
            //modifique los datos
            $_SESSION['mensaje']=$mensaje;
            header ('Location: ./abm_usuario.php');
        }else{
            //informo en la vista la modificacion o el error que hubo
            $_SESSION['mensaje']=$mensaje;
            $_SESSION['idModificar']=$id;
            header ('Location: ./modificacion_usuario.php'); 
        }
    }
    else{
        header('Location: ../usuario/administrador.php');
    }
}
 else{
   //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }
