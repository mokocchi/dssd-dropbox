<?php 
if (!isset($_SESSION)) {
    session_start();
}

require_once '../../vendor/autoload.php';

if (isset($_SESSION['emailUsuario'])){
    require_once '../../modelo/usuario.php';
    
    //obtengo el nombre del usuario logueado
    $nombreUsuario=$_SESSION['nombreUsuario'];
    $mensaje=$_SESSION['mensaje']; 
    
    
    $usuarioInst=new Usuario();
    
    //esto es por si viene de otro controlador informando el exito
    if(!isset($mensaje)){
        $mensaje="";
    }
    
    if(isset($_POST['filtro'])){
        $filtro=$_POST['filtro'];
        switch ($filtro) {
            case '1':
                $listaUsuarios=$usuarioInst->listadoUsuarios() ;
                $seleccionar = '1';
            break;
            case '2':
                $listaUsuarios=$usuarioInst->listadoUsuariosActivos() ;
                $seleccionar = '2';
                break;
            case '3':
                $listaUsuarios=$usuarioInst->listadoUsuariosDesactivados() ;
                $seleccionar = '3';
                break;
        }    
    }
    else{
        $listaUsuarios=$usuarioInst->listadoUsuariosActivos() ;
        $seleccionar = '2'; 
    }
    if(count($listaUsuarios)>0){
        //si hay usuarios muestro la lista de usuarios
        $parametrosVista = array( 'nombreUsuario' => $nombreUsuario,
                                  'listaUsuarios' => $listaUsuarios,
                                  'mensaje' => $mensaje,
                                  'seleccionar'=> $seleccionar);      
    }
    else {
        //sino muestro un mensaje avisando que no hay
        $mens="No hay usuarios para mostrar. Por favor agregue uno.";
        if($seleccionar == 3){
            $mens="No hay usuarios inactivos.";
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
    $template = $twig->loadTemplate("abm_usuario.twig");
    
    $template->display($parametrosVista);
    $_SESSION['mensaje']="";
}
 else{
    //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }

