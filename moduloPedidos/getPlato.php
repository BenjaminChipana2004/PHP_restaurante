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
                    borrarCookie("idCategoria");
                    $categorias = $objControl -> obtenerCategorias();
                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formCategoriasPlatosShow($categorias);
                break;
                case 'agregar':
                    $idPlato = $_POST['idPlato'];
                    $idPedido = $_COOKIE['idPedido'];
                    $objControl -> agregarPlatoAPedido($idPlato, $idPedido);

                    $idCategoria = $_COOKIE['idCategoria'];
                    $platosCategoria = $objControl -> obtenerPlatosEnCategoria($idCategoria);
                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formPlatosDisponiblesShow($platosCategoria);
                break;
            }
            exit;
        }
    }