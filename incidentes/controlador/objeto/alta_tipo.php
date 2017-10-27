<?php 
if (!isset($_SESSION)) {
    session_start();
}
require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/tipo.php';
    require_once '../../modelo/categoria.php';
    
    //obtengo el nombre del usuario logueado
    $nombreUsuario=$_SESSION['nombreUsuario'];
    $mensaje=$_SESSION['mensaje']; 
    
    //con este mensaje aviso si hubo error, si no hubo lo setteo vacio
    if(!isset($mensaje)){
        $mensaje="";
    }
    
    //obtengo la lista de las categorias activas para mostrar en el select
    $estadoInst=new Categoria();
    $listaEstados=$estadoInst->listadoCategoriasActivas();
    
    //Instanciamos Twig
    Twig_Autoloader::register();

    //Definimos el directorio de las vistas
    $dir = "../../vista";
    $loader = new Twig_Loader_Filesystem($dir);
    $twig = new Twig_Environment($loader);

    //Cargamos el template de la vista correspondiente
    $template = $twig->loadTemplate("alta_tipo.twig");
    $parametrosVista = array( 'nombreUsuario' => $nombreUsuario,
                              'listaCategorias' => $listaEstados,
                              'mensaje' => $mensaje);             
    
    $template->display($parametrosVista);
    $_SESSION['mensaje']="";
}
 else{
   //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }
