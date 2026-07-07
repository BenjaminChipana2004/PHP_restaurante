<?php
    function validaBotonAgregar($boton)
    {
        return isset($boton);
    }

    function validarCasillas($n, $a, $d, $f, $c, $p, $r)
    {
        return (!empty($n) && !empty($a) && !empty($d) && !empty($f) && !empty($c) && !empty($p) && !empty($r));
    }

    function validarDNI($dni)
    {
        return (strlen($dni) === 8 && is_numeric($dni));
    }

    $boton = $_POST['btnAgregar'];

    if (!validaBotonAgregar($boton)) {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();
        $objMensaje->mensajeSistemaBoxShow("ERROR: Acceso no válido al formulario", "<a href='../index.php'>Regresar al inicio</a>");
    } else {
        // Capturamos variables
        $nombre = trim($_POST['txtNombre']);
        $apellido = trim($_POST['txtApellido']);
        $dni = trim($_POST['txtDNI']);
        $fecha = trim($_POST['txtFechaNacimiento']);
        $correo = trim($_POST['txtCorreo']);
        $contrasena = trim($_POST['txtContrasena']); // Puedes aplicarle md5() aquí si tu sistema lo requiere
        $rol = $_POST['cboRol'];

        if (!validarCasillas($nombre, $apellido, $dni, $fecha, $correo, $contrasena, $rol)) {
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();
            $objMensaje->mensajeSistemaBoxShow("ERROR: Todas las casillas son obligatorias", "<a href='javascript:history.back()'>Vuelva a intentar</a>");
        } else {
            if (!validarDNI($dni)) {
                include_once('../shared/mensajeSistemaBox.php');
                $objMensaje = new mensajeSistemaBox();
                $objMensaje->mensajeSistemaBoxShow("ERROR: El DNI debe contener exactamente 8 números", "<a href='javascript:history.back()'>Vuelva a intentar</a>");
            } else {
                // Pasamos al controlador para la lógica de base de datos
                include_once("controllerAgregarUsuario.php");
                $objControl = new ControllerAgregarUsuario(); 
                
                // Primero consultamos si el DNI existe (como dice el diagrama de secuencia)
                $existeDNI = $objControl->consultaDNI($dni);

                if ($existeDNI > 0) {
                    include_once('../shared/mensajeSistemaBox.php');
                    $objMensaje = new mensajeSistemaBox();
                    $objMensaje->mensajeSistemaBoxShow("ERROR: El DNI '$dni' ya se encuentra registrado", "<a href='javascript:history.back()'>Modificar DNI</a>");
                } else {
                    // Si no existe, lo creamos
                    $objControl->crearNuevoUsuario($nombre, $apellido, $dni, $fecha, $correo, $contrasena, $rol);
                }
            }
        }
    }
?>