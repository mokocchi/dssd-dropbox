<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])) {
    require_once '../../modelo/tipo.php';
    require_once '../validador.php';

    if (isset($_POST['activo']) && isset($_POST['nombre']) && isset($_POST['idTipo']) && isset($_POST['imagenOriginal']) && isset($_POST['categoria']) && isset($_POST['nombreOriginal'])) {

        //obtengo los datos para modificar
        $nom = $_POST['nombre'];
        $nomOriginal = $_POST['nombreOriginal'];
        $imagenOriginal = $_POST['imagenOriginal'];
        $categoria = $_POST['categoria'];
        $id = $_POST['idTipo'];
        $activo = $_POST['activo'];
        
        //Recupero la ruta de la imagen seleccionada
        $ruta = $_FILES['imagen']['tmp_name'];
        
        //agrego los datos
        $tipoInst = new Tipo();

        //controlo los datos que vienen por post y si esta ok doy la modificacion
        $mensajeOk = false;
        if (($imagenOriginal != '') && ($nom != '') && ($id != '') && ($activo != '') && ($categoria != '') && ($nomOriginal != '')) {
            $nom = trim($nom);
            $arreglo_nombre = array('valor' => $nom, 'tipo' => 'Nombre', 'error' => false, 'mensajeError' => '');

            $patron = '/^[a-zA-Z\s]*$/';
            if (preg_match($patron, $arreglo_nombre['valor'])) {
                $arreglo_nombre['error'] = false;
            } else {
                $arreglo_nombre['error'] = true;
                $arreglo_nombre['mensajeError'] = "El nombre debe contener solo letras.";
            }
            
            $parametros = array($arreglo_nombre);
            
            //$parametros = validarCampos(array($arreglo_nombre));
            if ($parametros[0]['error'] !== true) {
                $seguir = true;
                //Recupero el nombre de la imagen seleccionada
                $imagen = basename($_FILES['imagen']['name']);
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
                    //Indico la ruta que ya tenia si no selecciono una imagen nueva donde quiero guardar las imagenes
                    $destino = $imagenOriginal;
                }
                if ($seguir) {
                    $tipoExiste = $tipoInst->existeTipo($email);
                    if ((count($tipoExiste) == 0) || ($nom == $nomOriginal)) {
                        Try {
                            $mensaje = "SIGUIO Y TRY" . $destino;
                            $tipoInst->modificacionTipo($id, $nom, $destino, $categoria, $activo);
                            copy($ruta, $destino);
                            $mensajeOk = true;
                        } catch (PDOException $e) {
                            $mensaje = 'ERROR: No se pudo modificar el tipo.' . $e->getMessage();
                            $mensajeOk = false;
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
            // $mensaje = 'Se han modificado los datos con exito.';
            //modifique los datos
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ./abm_tipo.php');
        } else {
            //informo en la vista la modificacion o el error que hubo
            $_SESSION['mensaje'] = $mensaje;
            $_SESSION['idModificar'] = $id;
            header('Location: ./modificacion_tipo.php');
        }
    } else {
        header('Location: ../usuario/administrador.php');
    }
} else {
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
}
