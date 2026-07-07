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
    $privilegioNecesario = "agregar usuario";
    if(!validarPrivilegio($privilegioNecesario,$listaPrivilegios))
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();
        $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no autorizado","<a href='../index.php'>ingresar correctamente</a>");
    } 
    else
    {
        include_once('../moduloAgregar/formAgregarUsuario.php');
        $objForm = new formAgregarUsuario();
        $objForm -> formCrearNuevoUsuario();
    }