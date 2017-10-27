<?php
require_once '../../vendor/autoload.php';

Twig_Autoloader::register();

$dir = '../../vista';
$loader = new Twig_Loader_Filesystem($dir);
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate("login.twig");

$mensaje="";
if(isset($_GET['mensaje'])){
        $mensaje=$_GET['mensaje'];
    }

$template->display(array('mensaje' => $mensaje));