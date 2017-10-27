<?php 
if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/usuario.php';
    require_once '../validador.php';
    
    if (isset($_POST['clave']) && isset($_POST['clave_2']) && isset($_POST['nombre']) && isset($_POST['apellido'])&& isset($_POST['email'])){
         //obtengo los datos a agregar
        $clave=$_POST['clave'];
        $clave_2=$_POST['clave_2'];
        $nom=$_POST['nombre'];
        $ape=$_POST['apellido'];
        $email=$_POST['email'];
        
        //controlo los datos que vienen por post y si esta ok doy el alta
        $mensajeOk=false;
        if(($clave !='')&&($clave_2 !='')&&($nom !='')&&($ape !='')&&($email !='')){
            $nom=trim($nom);
            $arreglo_nombre=array ('valor'=> $nom,'tipo' => 'Nombre', 'error'=> false, 'mensajeError' => '');
            $ape=trim($ape);
            $arreglo_apellido=array ('valor'=> $ape,'tipo' => 'Apellido', 'error'=> false, 'mensajeError' => '');
            $email=trim($email);
            $arreglo_email=array ('valor'=> $email,'tipo' => 'mail', 'error'=> false, 'mensajeError' => '');
            $arreglo_clave= array ('valor'=> $clave,'valor_2'=> $clave_2, 'tipo' => 'clave', 'error'=> false, 'mensajeError' => '');
            
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

            //estos arreglos se envian como  parametro para ser validados
            $parametros = array ($arreglo_nombre,$arreglo_apellido,$arreglo_email,$arreglo_clave);
            $parametros= validarCampos ($parametros);         
            
            if($parametros[0]['error']!==true &&($parametros[1]['error']!==true)&&
            ($parametros[2]['error']!==true)){
                $usuarioInst= new Usuario();
                $usuarioExiste=$usuarioInst->existeUsuario($email);
                if(count($usuarioExiste) == 0){
                    if($parametros[3]['error']!==true){
                        Try{ 
                            $passEncriptada=password_hash($clave,PASSWORD_BCRYPT);
                            $usuarioInst->altaUsuario($passEncriptada,$nom,$ape,$email);
                            $mensajeOk=true;
                        } 
                        catch (PDOException $e) {
                            $mensaje= 'ERROR: No se ha podido dar de alta el usuario. ' . $e->getMessage();
                        }
                    }
                    else{
                        $mensaje="El siguiente campo no es correcto: " . $parametros[3]['mensajeError'];
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
            $mensaje='Se agrego un nuevo usuario.';
            //agregue un usuario nuevo
            $_SESSION['mensaje']=$mensaje;
            header ('Location: ./abm_usuario.php');
        }else{
            //informo en la vista del alta el error que hubo
            $_SESSION['mensaje']=$mensaje; 
            header ('Location: ./alta_usuario.php'); 
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
