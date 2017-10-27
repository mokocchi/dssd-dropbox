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
    
    //obtengo el id del tipo a cambiar
    $ok=false;
    if(isset($_SESSION['idModificar'])&&($_SESSION['idModificar']!="")){
       $id=$_SESSION['idModificar']; 
       $ok=true;
    }
    else{
        if(isset($_POST['id'])){
            $id=$_POST['id'];
            $ok=true;
        }
    }
    if($ok){
        //obtengo los datos del tipo a modificar
        $mTipo= new Tipo();
        $datosTipo = $mTipo->datosTipoConId($id);
        
        //obtengo la lista de las categorias activas para mostrar en el select
        $estadoInst=new Categoria();
        $listaEstados=$estadoInst->listadoCategoriasActivas();
        
        //Instanciamos Twig
        Twig_Autoloader::register();

        //Definimos el directorio de las vistas
        $dir = "../../vista";
        $loader = new Twig_Loader_Filesystem($dir);
        $twig = new Twig_Environment($loader);
        $parametrosVista = array( 'nombreUsuario' => $nombreUsuario,
                              'datosTipo' => $datosTipo,
                              'listaCategorias' => $listaEstados,
                              'mensaje' => $mensaje);  
        //Cargamos el template de la vista correspondiente
        $template = $twig->loadTemplate("modificacion_tipo.twig");
        $template->display($parametrosVista);
        $_SESSION['mensaje']="";
        $_SESSION['idModificar']="";
    }
    else{
        header('Location: ../usuario/administrador.php');
    }
}
 else{
   //No hay sesion abierta o no tiene permisos de acceso
    header('Location: ../login/logout.php');
 }
