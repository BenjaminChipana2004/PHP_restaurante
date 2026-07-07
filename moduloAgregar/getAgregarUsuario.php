<?php
    function validarBoton($boton)
    {
        return isset($boton);
    }

    function validarCajasTexto($login, $password)
    {
        return strlen($login) >= 3 && strlen($password) >= 4;
    }

    $login = strtolower(trim($_POST['txtNuevoLogin']));
    $password = trim($_POST['txtNuevoPassword']);
    $boton = $_POST['btnRegistrarUsuario'];

    if (!validarBoton($boton)) {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();
        $objMensaje->mensajeSistemaBoxShow("ERROR: Acceso no válido", "<a href='../index.php'>Ir al inicio</a>");
    } else {
        if (!validarCajasTexto($login, $password)) {
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();
            $objMensaje->mensajeSistemaBoxShow("ERROR: Los datos ingresados no cumplen con la longitud requerida", "<a href='javascript:history.back()'>Vuelva a intentar</a>");
        } else {
            include_once("controllerAgregarUsuario.php");
            $objControl = new controllerAgregarUsuario(); 
            $objControl->agregarUsuario($login, $password);
        }
    }
?>