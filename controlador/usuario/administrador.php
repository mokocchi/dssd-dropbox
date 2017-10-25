<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])) {
    require_once '../../modelo/expediente.php';
    
    $nombreUsuario = $_SESSION['nombreUsuario'];
    $idUsuario = $_SESSION['idUsuario'];
    $mensaje = $_SESSION['mensaje'];
    if (!isset($mensaje)) {
        $mensaje = "";
    }

    $expedienteInst = new Expediente();

    $listaExpedientes = $expedienteInst->listadoExpedientesDelCliente($idUsuario);

    if (count($listaExpedientes) > 0) {

        $parametrosVista = array('nombreUsuario' => $nombreUsuario,
            'listaExpedientes' => $listaExpedientes,
            'mensaje' => $mensaje);
    } else {
        //sino muestro un mensaje avisando que no hay
        $mens = "No has registrado ningún incidente.";

        $parametrosVista = array('nombreUsuario' => $nombreUsuario,
            'mens' => $mens);
    }

    //Instanciamos Twig
    Twig_Autoloader::register();
    $dir = '../../vista';
    $loader = new Twig_Loader_Filesystem($dir);
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate("administrador.twig");
    $template->display($parametrosVista);
} else {
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
}