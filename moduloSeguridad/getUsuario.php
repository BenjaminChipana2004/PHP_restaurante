<?php
    function validarBoton($boton)
    {
        return isset($boton);
    }

    function validarCajasTexto($correo,$contrasena)
    {
        return strlen($correo) >= 3 && strlen($contrasena) >= 4;
    }

    $correo = strtolower(trim($_POST['txtCorreo']));
    $contrasena = trim($_POST['txtContrasena']);
    $boton = $_POST['btnAceptar'];
    if(!validarBoton($boton))
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();  
        $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no valido","<a href='../index.php'>ingresar correctamente</a>");
    }
    else
    {
        if(!validarCajasTexto($correo,$contrasena))
        {
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();
            $objMensaje -> mensajeSistemaBoxShow("ERROR: los datos ingresados no son validos","<a href='../index.php'>vuelva a intentar</a>");
        }
        else
        {
           include_once("controllerAutenticarUsuario.php");
           $objControl = new controllerAutenticarUsuario(); 
           $objControl -> validarUsuario($correo,$contrasena);
        }
    }
?>