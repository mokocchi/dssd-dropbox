<?php 
if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/incidente.php';
    
    //obtengo el nombre del usuario logueado
    $nombreUsuario=$_SESSION['nombreUsuario'];
    $mensaje=$_SESSION['mensaje']; 
    
    //con este mensaje aviso si hubo error, si no hubo lo setteo vacio
    if(!isset($mensaje)){
        $mensaje="";
    }
    
    $incidenteInst=new Incidente();
    $listaIncidentes=$incidenteInst->listadoIncidentes();
    
    //Instanciamos Twig
    Twig_Autoloader::register();

    //Definimos el directorio de las vistas
    $dir = "../../vista";
    $loader = new Twig_Loader_Filesystem($dir);
    $twig = new Twig_Environment($loader);

    //Cargamos el template de la vista correspondiente
    $template = $twig->loadTemplate("alta_expediente.twig");
    $parametrosVista = array( 'nombreUsuario' => $nombreUsuario,
                              'listaIncidentes' => $listaIncidentes,
                              'mensaje' => $mensaje);             
    
    $template->display($parametrosVista);
    $_SESSION['mensaje']="";
}
 else{
   //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }
