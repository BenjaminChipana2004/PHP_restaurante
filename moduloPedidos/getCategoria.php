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
    function crearCookie($nombre, $valor)
    {
        setcookie($nombre, $valor, time() + 3600, "/");
    }
    
    $boton = $_POST['boton'];
    $privilegioNecesario = "registrar pedido";
    $listaPrivilegios = $_SESSION['listaPrivilegios'];

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
            include_once('../moduloPedidos/controllerRegistrarPedido.php');    
            $objControl = new controllerRegistrarPedido();
            switch($boton)
            {
                case 'volver':
                    $nroMesa = $_COOKIE['nroMesa'];
                    $idPedido = $_COOKIE['idPedido'];
                    $platosPedido = $objControl -> obtenerPlatosEnPedido($idPedido);
                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formListaPedidosShow($nroMesa, $platosPedido);
                break;
                case 'categoria':
                    $idCategoria = $_POST['idCategoria'];
                    $platosCategoria = $objControl -> obtenerPlatosEnCategoria($idCategoria);

                    crearCookie("idCategoria", $idCategoria);

                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formPlatosDisponiblesShow($platosCategoria);
                break;
            }
            exit;
        }
    }