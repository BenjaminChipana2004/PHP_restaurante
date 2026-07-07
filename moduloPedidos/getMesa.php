<?php
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    function validarBoton($boton)
    {
        return isset($boton);
    }
    function validarPrivilegio($privilegioNecesario,$listaPrivilegios)
    {
        return in_array($privilegioNecesario,$listaPrivilegios);
    }
    
    $boton = $_POST['boton'];
    $idMesa = $_POST['idmesa'];
    $nroMesa = $_POST['nromesa'];
    $listaPrivilegios = $_SESSION['listaPrivilegios'];
    $privilegioNecesario = "registrar pedido";
    
    if(!validarBoton($boton))
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();  
        $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no valido","<a href='../moduloPedidos/indexPedido.php'>ingresar correctamente</a>");
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
            switch($boton)
            {
                case 'volver':
                    include_once('../shared/formPanelControl.php');
                    $objForm = new formPanelControl();
                    $objForm -> formPanelControlShow($listaPrivilegios);
                break;
                case 'mesa':
                    include_once('../moduloPedidos/controllerRegistrarPedido.php');
                    $objControl = new controllerRegistrarPedido();
                    $platosPedido = $objControl -> obtenerPlatosEnMesa($idMesa);
                break;
            }
        }
    }