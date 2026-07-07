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

    // 1. Capturamos el texto del botón presionado en el panel dinámico
    $boton = $_POST['btnCasoUso'];

    // =========================================================================
    // BLOQUE DE INTERCEPCIÓN Y TRADUCCIÓN COMERCIAL -> TÉCNICO
    // =========================================================================
    if ($boton === 'efectuar cobro') {
        $boton = 'realizar cobro'; // Cambiamos el valor para que encaje con tu switch y tu Rational Rose
        
        // Le damos el pase de seguridad agregando 'realizar cobro' a la sesión si no existía
        if (!in_array('realizar cobro', $_SESSION['listaPrivilegios']) && in_array('efectuar cobro', $_SESSION['listaPrivilegios'])) {
            $_SESSION['listaPrivilegios'][] = 'realizar cobro';
        }
    }
    // =========================================================================

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
                case 'registrar pedido':
                    include_once('../moduloPedidos/controllerRegistrarPedido.php');
                    $objControl = new controllerRegistrarPedido();
                    $mesasDisponibles=$objControl -> obtenerMesasDisponibles();
                    include_once('../moduloPedidos/formRegistrarPedido.php');
                    $objForm = new formRegistrarPedido();
                    $objForm -> formMesasDisponiblesShow($mesasDisponibles);
                break;
                
                case 'registrar despacho':
                    include_once('../moduloVentas/controllerRegistrarDespacho.php');
                    $objControl = new controllerRegistrarDespacho();
                    $platosCocina=$objControl -> obtenerPlatosCocina();
                    include_once('../moduloVentas/formRegistrarDespacho.php');
                    $objForm = new formRegistrarDespacho();
                    $objForm -> formRegistrarDespachoShow($platosCocina);
                break;

                case 'realizar cobro':
                    include_once('../moduloCobros/controllerRealizarCobro.php');
                    include_once('../moduloCobros/formRealizarCobro.php');
                    $objForm = new formRealizarCobro();
                    $objForm -> formRealizarCobroShow();
                break;

                case 'registrar insumos':
                    include_once('../moduloInsumos/ControllerRegistrarInsumo.php');
                    $objControl = new ControllerRegistrarInsumo();
                    $listaInsumos = $objControl->obtenerStock();

                    include_once('../moduloInsumos/formRegistrarInsumo.php');
                    $objForm = new formRegistrarInsumo();
                    $objForm->formRegistrarInsumoShow($listaInsumos, false);
                break;

                // =========================================================================
                // LÍNEAS NUEVAS: CASO DE USO AGREGAR USUARIO
                // =========================================================================
                case 'crear nuevo usuario':
                    include_once('../moduloSeguridad/ControllerAgregarUsuario.php');
                    $objControl = new ControllerAgregarUsuario();
                    $objControl->mostrarFormulario();
                break;
                // =========================================================================

                default:
                    /*
                    case 'actualizar platos':
                        include_once('../moduloAdministracion/controllerActualizarPlatos.php');
                        $objControl = new controllerActualizarPlatos();
                        $objControl -> actualizarPlatos();
                    break;
                    case 'registrar reclamo':
                        include_once('../moduloVentas/controllerRegistrarReclamo.php');
                        $objControl = new controllerRegistrarReclamo();
                        $objControl -> registrarReclamo();
                    break;
                    case 'actualizar usuarios':
                        include_once('../moduloSeguridad/controllerActualizarUsuarios.php');
                        $objControl = new controllerActualizarUsuarios();
                        $objControl -> actualizarUsuarios();
                    break;
                    */
                    include_once('../shared/mensajeSistemaBox.php');
                    $objMensaje = new mensajeSistemaBox();
                    $objMensaje -> mensajeSistemaBoxShow("ERROR: Caso de uso no encontrado","<a href='../index.php'>ingresar correctamente</a>");
           }
        }
    }
?>
