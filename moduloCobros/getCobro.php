<?php
// Eliminamos la inclusión directa del modelo; ahora se maneja mediante el controlador de caso de uso
require_once 'controllerRealizarCobro.php';

class GetCobro 
{
    public function validarBoton($boton) { return isset($boton); }
    public function validarPrivilegio() { return true; } 
    public function validarNroMesa($NroMesa) { return !empty($NroMesa); }
}

$boton = isset($_POST['btnBuscarMesa']) ? $_POST['btnBuscarMesa'] : null;
$NroMesaInput = isset($_POST['txtMesa']) ? trim($_POST['txtMesa']) : '';

// Variable estandarizada al estilo de tu compañero
$objControl = new GetCobro();

// FILTRO 1: image_06ea90.png -> "ERROR: Acceso no valido"
if (!$objControl->validarBoton($boton)) 
{
    include_once('../shared/mensajeSistemaBox.php');
    $objMensaje = new mensajeSistemaBox();  
    $objMensaje->mensajeSistemaBoxShow("ERROR: Acceso no valido", "<a href='formRealizarCobro.php'>Regresar</a>");
}
else 
{
    // FILTRO 2: image_06ea90.png -> "ERROR: Acceso no autorizado"
    if (!$objControl->validarPrivilegio()) 
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();  
        $objMensaje->mensajeSistemaBoxShow("ERROR: Acceso no autorizado", "<a href='formRealizarCobro.php'>Regresar</a>");
    }
    else 
    {
        // FILTRO 3: image_fc8201.png / validación de campo vacío
        if (!$objControl->validarNroMesa($NroMesaInput)) 
        {
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();  
            $objMensaje->mensajeSistemaBoxShow("Error: Campo vacío", "<a href='formRealizarCobro.php'>Regresar e intentar correctamente</a>");
        }
        else 
        {
            // CAPA CONTROLADOR: Instanciamos el controlador del caso de uso dibujado en Rational Rose
            $objControladorCasoUso = new controllerRealizarCobro();
            // Ejecutamos la operación formal definida en el diagrama de clases
            $pedidoEncontrado = $objControladorCasoUso->obtenerPedidoDetalle($NroMesaInput);

            // FILTRO 4: image_06ea90.png -> "Mesa no encontrada o sin pedidos"
            if (!$pedidoEncontrado) 
            {
                include_once('../shared/mensajeSistemaBox.php');
                $objMensaje = new mensajeSistemaBox();  
                $objMensaje->mensajeSistemaBoxShow("Mesa no encontrada o sin pedidos", "<a href='formRealizarCobro.php'>Buscar otra mesa</a>");
            }
            else 
            {
                if (session_status() === PHP_SESSION_NONE) { session_start(); }
                $_SESSION['pedido_actual'] = $pedidoEncontrado;
                $_SESSION['nro_mesa_actual'] = $NroMesaInput;

                // Redirecciona a la vista unificada
                header("Location: formRealizarCobro.php?status=PedidoEncontrado");
                exit();
            }
        }
    }
}
?>