<?php
    function validarBoton($boton)
    {
        return isset($boton);
    }
    function validarPrivilegio($boton,$listaPrivilegios)
    {
        return in_array($boton,$listaPrivilegios);
    }
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $boton = $_POST['btnCasoUso'];
    $listaPrivilegios = $_SESSION['listaPrivilegios'];
    if(!validarBoton($boton))
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();  
        $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no valido","<a href='../index.php'>ingresar correctamente</a>");
    }
    else
    {
        if(!validarPrivilegio($boton,$listaPrivilegios))
        {
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();
            $objMensaje -> mensajeSistemaBoxShow("ERROR: Acceso no autorizado","<a href='../index.php'>ingresar correctamente</a>");
        }
        else
        {
           switch($boton)
           {
            /*
                case 'actualizar platos':
                    include_once('../moduloAdministracion/controllerActualizarPlatos.php');
                    $objControl = new controllerActualizarPlatos();
                    $objControl -> actualizarPlatos();
                break;
                case 'registrar pedido':
                    include_once('../moduloVentas/controllerRegistrarPedido.php');
                    $objControl = new controllerRegistrarPedido();
                    $objControl -> registrarPedido();
                break;
                */
                case 'registrar despacho':
                    include_once('../moduloVentas/controllerRegistrarDespacho.php');
                    $objControl = new controllerRegistrarDespacho();
                    $platosCocina=$objControl -> obtenerPlatosCocina();
                    include_once('../moduloVentas/formRegistrarDespacho.php');
                    $objForm = new formRegistrarDespacho();
                    $objForm -> formRegistrarDespachoShow($platosCocina);
                break;
                /*
                case 'efectuar cobro':
                    include_once('../moduloVentas/controllerEfectuarCobro.php');
                    $objControl = new controllerEfectuarCobro();
                    $objControl -> efectuarCobro();
                break;
                case 'registrar reclamo':
                    include_once('../moduloVentas/controllerRegistrarReclamo.php');
                    $objControl = new controllerRegistrarReclamo();
                    $objControl -> registrarReclamo();
                break;
                case 'registrar insumos':
                    include_once('../moduloAdministracion/controllerRegistrarInsumos.php');
                    $objControl = new controllerRegistrarInsumos();
                    $objControl -> registrarInsumos();
                break;
                case 'actualizar usuarios':
                    include_once('../moduloSeguridad/controllerActualizarUsuarios.php');
                    $objControl = new controllerActualizarUsuarios();
                    $objControl -> actualizarUsuarios();
                break;
                */
                default:
                    include_once('../shared/mensajeSistemaBox.php');
                    $objMensaje = new mensajeSistemaBox();
                    $objMensaje -> mensajeSistemaBoxShow("ERROR: Caso de uso no encontrado","<a href='../index.php'>ingresar correctamente</a>");
           }
        }
    }