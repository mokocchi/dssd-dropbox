<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])) {
    require_once '../../modelo/tipo.php';
    require_once '../validador.php';

    if (isset($_FILES['imagen']['name']) && isset($_POST['categoria']) && isset($_POST['nombre'])) {
        //obtengo los datos ha agregar
        $categoria = $_POST['categoria'];
        $nom = $_POST['nombre'];

        //Recupero el nombre de la imagen seleccionada
        $imagen = basename($_FILES['imagen']['name']);
        //Recupero la ruta de la imagen seleccionada
        $ruta = $_FILES['imagen']['tmp_name'];


        //controlo los datos que vienen por post y si esta ok doy el alta
        $mensajeOk = false;
        if (($imagen != '') && ($categoria != '') && ($nom != '')) {
            $nom = trim($nom);
            $arreglo_nombre = array('valor' => $nom, 'tipo' => 'Nombre', 'error' => false, 'mensajeError' => '');


            $patron = '/^[a-zA-Z\s]*$/';
            if (preg_match($patron, $arreglo_nombre['valor'])) {
                $arreglo_nombre['error'] = false;
            } else {
                $arreglo_nombre['error'] = true;
                $arreglo_nombre['mensajeError'] = "El nombre debe contener solo letras.";
            }


            //estos arreglos se envian como  parametro para ser validados
            $parametros = array($arreglo_nombre);
            //  $parametros = validarCampos($parametros);
            if ($parametros[0]['error'] !== true) {
                $seguir = true;
                if ($imagen != "") {
                    $mTipo = exif_imagetype($ruta);
                    if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG) && ($mTipo != IMAGETYPE_GIF)) {
                        $seguir = false;
                        $mensaje = "La extensión de la imagen seleccionada no es valida(jpeg/jpg,png,gif).";
                    } else {
                        //Indico la ruta donde quiero guardar las imagenes
                        $destino = "../../imagenes/tipo_" . $nom . "_" . $imagen;
                    }
                } else {
                    $seguir = false;
                    $mensaje = "No se pudo cargar la imagen.";
                }

                if (seguir) {
                    $tipoInst = new Tipo();
                    $tipoExiste = $tipoInst->existeTipo($nom);
                    if (count($tipoExiste) == 0) {
                        Try {
                            $tipoInst->altaTipo($nom, $destino, $categoria);
                            //guardo en la carpeta imagenes la imagen seleccionada
                            copy($ruta, $destino);
                            $mensajeOk = true;
                        } catch (PDOException $e) {
                            $mensaje = 'ERROR: No se ha podido dar de alta el tipo. ' . $e->getMessage();
                        }
                    } else {
                        $mensaje = "El nombre de tipo ya existe.";
                    }
                }
            } else {
                $mensaje = "" . $parametros[0]['mensajeError'];
            }
        } else {
            $mensaje = 'Debe completar todos los campos.';
        }
        if ($mensajeOk) {
            $mensaje = 'Se agrego un nuevo tipo.';
            //agregue un tipo nuevo
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ./abm_tipo.php');
        } else {
            //informo en la vista del alta el error que hubo
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ./alta_tipo.php');
        }
    } else {
        header('Location: ../usuario/administrador.php');
    }
} else {
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
}
