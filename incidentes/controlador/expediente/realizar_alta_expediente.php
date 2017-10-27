<?php

    if (!isset($_SESSION)) {
        session_start();
    }
    require_once '../../vendor/autoload.php';

    if (isset($_SESSION['emailUsuario'])) {
        require_once '../../modelo/expediente.php';
        require_once '../../modelo/objeto.php';
        require_once '../validador.php';

        if (isset($_POST['incidente']) && isset($_POST['fecha']) && isset($_POST['cantidad']) && isset($_POST['descripcion'])&& isset($_POST['objeto'])) {
            //obtengo los datos ha agregar
            $incidente = $_POST['incidente'];
            $fecha = $_POST['fecha'];
            $cantidad = $_POST['cantidad'];
            $descripcion = $_POST['descripcion'];
            $cliente=$_SESSION['idUsuario'];
            $estado=1;
            
            //controlo los datos que vienen por post y si esta ok doy el alta
            $mensajeOk = false;
            $idExpediente=0;
            if (($incidente != '') && ($fecha != '') && ($cantidad != '') && ($descripcion != '')) {
                If (validateDate($fecha, 'Y-m-d')) {
                    $fecha = date("Y-m-d", strtotime($fecha));
                }
                if (validateDate($fecha, 'd/m/Y')) {
                    $partes = explode("/", $fecha);
                    $date = strtotime($partes[2] . $partes[1] . $partes[0]);
                    $fecha = date('Y-m-d', $date);
                }
                
                $expedienteInst= new Expediente();
                $objetoInst= new Estado();
                Try {
                    $idExpediente=$expedienteInst->altaExpediente($cliente,$incidente,$fecha,$cantidad,$descripcion,$estado);
                    for($i=1;$i<=$cantidad;$i++){
                       $objetoInst->altaObjeto($_POST['objeto'][$i]['nombre'],$_POST['objeto'][$i]['cant'],$_POST['objeto'][$i]['descrip'],$idExpediente); 
                    }
                    $mensajeOk = true;
                } catch (PDOException $e) {
                    $mensaje = 'ERROR: No se ha podido registrar el incidente. ' . $e->getMessage();
                }
            } else {
                $mensaje = 'Debe completar todos los campos.';
            }
            
            if ($mensajeOk) {
                $mensaje = 'Se registro correctamente el incidente.';
                //agregue un producto nuevo
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../usuario/administrador.php');
            } else {
                //informo en la vista del alta el error que hubo
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ./alta_expediente.php');
            }
        } else {
            header('Location: ../usuario/administrador.php');
        }
    } else {
        //No hay sesion abierta o no tiene permisos de acceso
        header('Location: ../login/logout.php');
    }
