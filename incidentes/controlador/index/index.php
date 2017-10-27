<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['nombreUsuario'])) {
    header('Location: ../usuario/administrador.php');
} else {
    //Instanciamos Twig
    // Twig_Autoloader::register();
    //Definimos el directorio de las vistas
//    $dir = "../../vista";
//    $loader = new Twig_Loader_Filesystem($dir);
//    $twig = new Twig_Environment($loader);
    //Cargamos el template de la vista correspondiente
//    $template = $twig->loadTemplate("index.twig");
//
//    $template->display(array());

    Twig_Autoloader::register();

    $dir = '../../vista';
    $loader = new Twig_Loader_Filesystem($dir);
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate("login.twig");

    $mensaje = "";
    if (isset($_GET['mensaje'])) {
        $mensaje = $_GET['mensaje'];
    }

    $template->display(array('mensaje' => $mensaje));
}