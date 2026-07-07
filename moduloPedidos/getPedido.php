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
    function borrarCookie($nombre)
    {
        setcookie($nombre, "", time() - 3600, "/");
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
                    borrarCookie("idPedido");
                    borrarCookie("nroMesa");

                    $mesasDisponibles = $objControl -> obtenerMesasDisponibles();
                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formMesasDisponiblesShow($mesasDisponibles);
                break;
                case 'cancelar':
                    $idPlatoPedido = $_POST['idPlatoPedido'];
                    $objControl -> cancelarPlatoEnPedido($idPlatoPedido);

                    $idPedido = $_COOKIE['idPedido'];
                    $nroMesa = $_COOKIE['nroMesa'];
                    $platosPedido = $objControl -> obtenerPlatosEnPedido($idPedido);

                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formListaPedidosShow($nroMesa, $platosPedido);
                break;
                case 'entregar':
                    $idPlatoPedido = $_POST['idPlatoPedido'];
                    $objControl -> entregarPlatoPedido($idPlatoPedido);
                    
                    $idPedido = $_COOKIE['idPedido'];
                    $nroMesa = $_COOKIE['nroMesa'];
                    $platosPedido = $objControl -> obtenerPlatosEnPedido($idPedido);

                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formListaPedidosShow($nroMesa, $platosPedido);
                case 'agregar plato':
                    $categorias = $objControl -> obtenerCategorias();
                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formCategoriasPlatosShow($categorias);
                break;
            }
        }
    }