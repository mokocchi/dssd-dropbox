<?php 
if (!isset($_SESSION)) {
    session_start();
}

require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/tipo.php';
    
    //obtengo el nombre del usuario logueado
    $nombreUsuario=$_SESSION['nombreUsuario'];
    $mensaje=$_SESSION['mensaje']; 
    
    
    $tipoInst=new Tipo();
    
    //esto es por si viene de otro controlador informando el exito
    if(!isset($mensaje)){
        $mensaje="";
    }
    
    if(isset($_POST['filtro'])){
        $filtro=$_POST['filtro'];
        switch ($filtro) {
            case '1':
                $listaTipos=$tipoInst->listadoTipos() ;
                $seleccionar = '1';
            break;
            case '2':
                $listaTipos=$tipoInst->listadoTiposActivos() ;
                $seleccionar = '2';
                break;
            case '3':
                $listaTipos=$tipoInst->listadoTiposDesactivados() ;
                $seleccionar = '3';
                break;
        }    
    }
    else{
        $listaTipos=$tipoInst->listadoTiposActivos() ;
        $seleccionar = '2'; 
    }
    if(count($listaTipos)>0){
        //si hay tipos muestro la lista de tipos
        $parametrosVista = array( 'nombreUsuario' => $nombreUsuario,
                                  'listaTipos' => $listaTipos,
                                  'mensaje' => $mensaje,
                                  'seleccionar'=> $seleccionar);      
    }
    else {
        //sino muestro un mensaje avisando que no hay
        $mens="No hay tipos para mostrar. Por favor agregue uno.";
        if($seleccionar == 3){
            $mens="No hay tipos inactivos.";
        }
        $parametrosVista = array( 'nombreUsuario' => $nombreUsuario,
                                  'mens' => $mens,
                                  'seleccionar' =>$seleccionar); 
    }
    //Instanciamos Twig
    Twig_Autoloader::register();

    //Definimos el directorio de las vistas
    $dir = "../../vista";
    $loader = new Twig_Loader_Filesystem($dir);
    $twig = new Twig_Environment($loader);
    $twig->addGlobal('session', $_SESSION);

    //Cargamos el template de la vista correspondiente
    $template = $twig->loadTemplate("abm_tipo.twig");
    
    $template->display($parametrosVista);
    $_SESSION['mensaje']="";
}
 else{
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }

