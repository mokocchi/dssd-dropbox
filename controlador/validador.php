<?php

date_default_timezone_set("America/Argentina/Buenos_Aires");

function validateDate($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validarFecha($fecha) {
    if (strlen($fecha['valor']) == 10) {
        if ((validateDate($fecha['valor'], 'Y-m-d')) || (validateDate($fecha['valor'], 'd/m/Y'))) {
            If (validateDate($fecha['valor'], 'Y-m-d')) {
                $fecha['valor'] = date("Y-m-d", strtotime($fecha['valor']));
            }
            if (validateDate($fecha['valor'], 'd/m/Y')) {
                $partes = explode("/", $fecha['valor']);
                $date = strtotime($partes[2] . $partes[1] . $partes[0]);
                $fecha['valor'] = date('Y-m-d', $date);
            }
        } else {
            $fecha['error'] = true;
            $fecha['mensajeError'] = "Fecha: no es valido.";
        }
    } else {
        $fecha['error'] = true;
        $fecha['mensajeError'] = "Fecha: no es correcto.";
    }
    return $fecha;
}

function validarFloat($num) {
    $patron = '/^[0-9]{1,4}(\.[0-9]{1,2})?$/'; //numeros de 0 a 9, de 1 a 4 digitos enteros, . opcional y tambien opcional 1 o 2 digitos decimales
    if (!$num['valor'] == 0) {
        if (preg_match($patron, $num['valor'])) {
            $num['error'] = false;
        } else {
            $num['error'] = true;
            $num['mensajeError'] = "Peso: no es valido.";
        }
    } else {
        $num['error'] = true;
        $num['mensajeError'] = "Peso: debe ser mayor a 0.";
    }
    return $num;
}

function validarNombre($nombre) {
    $patron = '/^[a-zA-Z\s]*$/';
    if (preg_match($patron, $nombre['valor'])) {
        $nombre['error'] = false;
    } else {
        $nombre['error'] = true;
        $nombre['mensajeError'] = $nombre['tipo'] . ": debe tener solo letras.";
    }
    return $nombre;
    //$patron = '/^[A-Za-z áéíóúÁÉÍÓÚñÑ]*([0-9])?$/';
}

function validarMail($mail) {
    if (filter_var($mail['valor'], FILTER_VALIDATE_EMAIL)) {
        $mail['error'] = false;
    } else {
        $mail['error'] = true;
        $mail['mensajeError'] = "E-mail: no es correcto.";
    }
    return $mail;
}

function validarTelefono($tel) {
    $patron = '/^([0-9]{3,5})(-){1}([0-9]{6,10})$/';
    if (preg_match($patron, $tel['valor'])) {
        $tel['error'] = false;
    } else {
        $tel['error'] = true;
        $tel['mensajeError'] = "Telefono: no es valido.";
    }
    return $tel;
}

function validarInteger($int) {
    $patron = '/^[0-9]{1,3}$/';
    if (preg_match($patron, $int['valor'])) {
        $int['error'] = false;
    } else {
        $int['error'] = true;
        $int['mensajeError'] = $int['tipo'] . ": debe contener solo numeros y como maximo 3 digitos.";
    }
    return $int;
}

function validarCodigo($cod) {
    $patron = '/^[A-Za-z]{5}[0-9]{5}$/';
    if (preg_match($patron, $cod['valor'])) {
        $cod['error'] = false;
    } else {
        $cod['error'] = true;
        $cod['mensajeError'] = "Codigo: debe contener 5 numeros y 5 letras.";
    }
    return $cod;
}

function validarDomicilio($dom) {
    $patron = '/^[A-Za-z0-9\s]{2,200}$/';
    if (preg_match($patron, $dom['valor'])) {
        $dom['error'] = false;
    } else {
        $dom['error'] = true;
        $dom['mensajeError'] = "Domicilio: solo puede tener letras y numeros, debe contener mas de un caracter.";
    }
    return $dom;
}

function validarClave($clave) {
    if ($clave['valor'] == $clave['valor_2']) {
        $clave['error'] = false;
    } else {
        $clave['error'] = true;
        $clave['mensajeError'] = "Clave: las claves ingresadas no son iguales.";
    }
    return $clave;
}

function validarHora($hora) {
    $patron = '/^((([01][0-9])|([2][0-3])):([0-5][0-9]))|(24:00)$/';
    if (preg_match($patron, $hora['valor'])) {
        $hora['error'] = false;
    } else {
        $hora['error'] = true;
        $hora['mensajeError'] = "Hora: la hora ingresada no es valida.";
    }
    return $hora;
}

function validarNombreUsuario($usuario) {
    $patron = '/^(?=.{5,18}$)(?!.*[._-]{2})[a-z][a-z0-9._-]*[a-z0-9]$/';
    if (preg_match($patron, $usuario['valor'])) {
        $usuario['error'] = false;
    } else {
        $usuario['error'] = true;
        $usuario['mensajeError'] = "Nombre Usuario: debe contener como minimo 5 caracteres permitidos(letras, numeros,-,.,_).";
    }
    return $usuario;
}

function validarImagen($archivo) {
    $imagen = $archivo['valor'];
    if (isset($imagen['imagen']['tmp_name'])) {
        $mTmpFile = $imagen["imagen"]["tmp_name"];
        $mTipo = exif_imagetype($mTmpFile);
        if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG) && ($mTipo != IMAGETYPE_GIF)) {
            $archivo['error'] = true;
            $archivo['mensajeError'] = "Imagen: la extensión de la imagen seleccionada no es valida(jpeg/jpg,png,gif).";
        } else {
            $archivo['error'] = false;
        }
    } else {
        $archivo['error'] = true;
        $archivo['mensajeError'] = "Imagen: el tamaño de la imagen seleccionada es muy grande.";
    }
    return $archivo;
}

function validarCampos($parametros) {
    for ($i = 0; $i < count($parametros); $i++) {
        switch ($parametros[$i]['

        tipo']) {
            case 'date':
                $parametros[$i] = validarFecha($parametros[$i]);
                break;
            case 'float':
                $parametros[$i] = validarFloat($parametros[$i]);
                break;
            case 'Nombre':
                $parametros[$i] = validarNombre($parametros[$i]);
                break;
            case 'Apellido':
                $parametros[$i] = validarNombre($parametros[$i]);
                break;
            case 'mail':
                $parametros[$i] = validarMail($parametros[$i]);
                break;
            case 'telefono':
                $parametros[$i] = validarTelefono($parametros[$i]);
                break;
            case 'Stock':
                $parametros[$i] = validarInteger($parametros[$i]);
                break;
            case 'Reservado':
                $parametros[$i] = validarInteger($parametros[$i]);
                break;
            case 'codigo':
                $parametros[$i] = validarCodigo($parametros[$i]);
                break;
            case 'Descripcion':
                $parametros[$i] = validarNombre($parametros[$i]);
                break;
            case 'domicilio':
                $parametros[$i] = validarDomicilio($parametros[$i]);
                break;
            case 'clave':
                $parametros[$i] = validarClave($parametros[$i]);
                break;
            case 'hora':
                $parametros[$i] = validarHora($parametros[$i]);
                break;
            case 'nUsuario':
                $parametros[$i] = validarNombreUsuario($parametros[$i]);
                break;
            case 'imagen':
                $parametros[$i] = validarImagen($parametros[$i]);
                break;
        }
    }
    return $parametros;
}
