<?php
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    function validarBoton($boton)
    {
        return isset($boton);
    }
    function validarPrivilegio($boton,$listaPrivilegios)
    {
        return in_array($boton,$listaPrivilegios);
    }
    
    $boton = $_POST['btnPlato'];
    $idPlato = $_POST['idPlato'];
    $listaPrivilegios = $_SESSION['listaPrivilegios'];
    $privilegioNecesario = "registrar despacho";
    
    if(!validarBoton($boton))
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();  
        $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no valido","<a href='../index.php'>ingresar correctamente</a>");
    }
    else
    {
        if(!validarPrivilegio($privilegioNecesario,$listaPrivilegios))
        {
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();
            $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no autorizado","<a href='../index.php'>ingresar correctamente</a>");
        }
        else
        {
            include_once('./controllerRegistrarDespacho.php');
            $objControl = new controllerRegistrarDespacho();
            switch($boton)
            {
                case 'cancelar':
                    $objControl -> cancelarPlato($idPlato);
                break;
                case 'enCocina':
                    $objControl -> enviarPlatoCocina($idPlato);
                break;
                case 'entregado':
                    $objControl -> entregarPlato($idPlato);
                break;
            }
            $platosCocina = $objControl -> obtenerPlatosCocina();
            include_once('../moduloVentas/formRegistrarDespacho.php');
            $objForm = new formRegistrarDespacho();
            $objForm -> formRegistrarDespachoShow($platosCocina);
            exit;
        }
    }