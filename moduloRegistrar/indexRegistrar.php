<?php
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    function validarPrivilegio($privilegioNecesario,$listaPrivilegios)
    {
        return in_array($privilegioNecesario,$listaPrivilegios);
    }
    $listaPrivilegios = $_SESSION['listaPrivilegios'];
    $privilegioNecesario = "registrar insumos";
    if(!validarPrivilegio($privilegioNecesario,$listaPrivilegios))
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();
        $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no autorizado","<a href='../index.php'>ingresar correctamente</a>");
    } 
    else
    {
        include_once('../moduloRegistrar/controllerRegistrarInsumo.php');
                    $objControl = new ControllerRegistrarInsumo();
                    $listaInsumos = $objControl->obtenerStock();

                    include_once('../moduloRegistrar/formRegistrarInsumo.php');
                    $objForm = new formRegistrarInsumo();
                    $objForm->formRegistrarInsumoShow($listaInsumos, false);
    }