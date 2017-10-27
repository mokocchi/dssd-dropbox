<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])) {
    require_once '../../modelo/expediente.php';
    require_once '../../modelo/objeto.php';

    if (isset($_POST['id'])) {
        //obtengo el nombre del usuario logueado
        $nombreUsuario=$_SESSION['nombreUsuario'];
        $mensaje=$_SESSION['mensaje']; 

        //con este mensaje aviso si hubo error, si no hubo lo setteo vacio
        if(!isset($mensaje)){
            $mensaje="";
        }

        $id = $_POST['id'];

        $expedienteInst = new Expediente();
        $datosExpediente = $expedienteInst->datosExpedienteConId($id);
        $datosExpediente['fecha_expediente']=date("d/m/Y",strtotime($datosExpediente['fecha_expediente']));

        $objetoInst = new Estado();
        $listaObjetos = $objetoInst->listadoObjetosDelExpediente($id);

        if (count($listaObjetos) > 0) {

            $parametrosVista = array('nombreUsuario' => $nombreUsuario,
                'datosExpediente' => $datosExpediente,
                'listaObjetos' => $listaObjetos,
                'mensaje' => $mensaje);
        } else {
            //sino muestro un mensaje avisando que no hay
            $mens = "No has registrado ningún objeto.";

            $parametrosVista = array('nombreUsuario' => $nombreUsuario,
                'mens' => $mens);
        }

        //Instanciamos Twig
        Twig_Autoloader::register();
        $dir = '../../vista';
        $loader = new Twig_Loader_Filesystem($dir);
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate("visualizar_expediente.twig");
        $template->display($parametrosVista);
    } else {
        header('Location: ../usuario/administrador.php');
    }
} else {
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
}
