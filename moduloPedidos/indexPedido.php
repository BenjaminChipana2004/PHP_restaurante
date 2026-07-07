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
    $privilegioNecesario = "registrar pedido";
    if(!validarPrivilegio($privilegioNecesario,$listaPrivilegios))
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();
        $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no autorizado","<a href='../index.php'>ingresar correctamente</a>");
    } 
    else
    {
        include_once('../moduloPedidos/controllerRegistrarPedido.php');
        $objControl = new controllerRegistrarPedido();
        $mesasDisponibles=$objControl -> obtenerMesasDisponibles();
        include_once('../moduloPedidos/formRegistrarPedido.php');
        $objForm = new formRegistrarPedido();
        $objForm -> formMesasDisponiblesShow($mesasDisponibles);
    }