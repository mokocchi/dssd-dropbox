<?php

require_once '../../modelo/usuario.php';
require_once '../../vendor/autoload.php';

session_start();

Twig_Autoloader::register();

$dir = '../../vista';
$loader = new Twig_Loader_Filesystem($dir);
$twig = new Twig_Environment($loader);

$usuario = $_POST["email"];
$password = $_POST["pass"];
if ($usuario != "" && $password != "") {
    $userInst = new Usuario();
    $usuario = trim($usuario);
    $user = $userInst->existeUsuarioActivo($usuario);

    if (count($user) > 0) {
        if ($password == $user['clave_usuario']) {
            //if ((password_verify ($password,$user['clave_usuario']))==true) {
            $_SESSION['nombreUsuario'] = $user['nombre_usuario'] . " " . $user['apellido_usuario'];
            $_SESSION['idUsuario'] = $user['id_usuario'];
            $_SESSION['emailUsuario'] = $user['email_usuario'];
            $_SESSION['mensaje'] = "";
            
            header('Location: ../usuario/administrador.php');
        } else {
            header('Location: ../login/login.php?mensaje=Clave incorrecta.');
        }
    } else {
        header('Location: ../login/login.php?mensaje=Correo electrónico de usuario inexistente.');
    }
} else {
    header('Location: ../login/login.php?mensaje=Complete todos los campos.');
}
 