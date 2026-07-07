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

                // ==========================================================
                // CASO DE USO INTEGRADO Y ACTIVADO: REALIZAR COBRO
                // ==========================================================
                case 'realizar cobro':
                    // 1. Incluimos tu controlador del caso de uso
                    include_once('../moduloCobros/controllerRealizarCobro.php');
                    
                    // 2. Incluimos tu formulario unificado
                    include_once('../moduloCobros/formRealizarCobro.php');
                    
                    // 3. Renderizamos la interfaz inicial (Buscar Mesa)
                    $objForm = new formRealizarCobro();
                    $objForm -> formRealizarCobroShow();
                break;

                /*
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
?>