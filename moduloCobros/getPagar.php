<?php
// Eliminamos la inclusión directa del modelo; ahora pasa a través del controlador del caso de uso
require_once 'controllerRealizarCobro.php';

class GetPagar 
{
    public function validarBoton($boton) { return isset($boton); }
    public function validarPrivilegio() { return true; } 
}

$boton = isset($_POST['btnPagarFactura']) ? $_POST['btnPagarFactura'] : null;
$idPedido = isset($_POST['hdnIdPedido']) ? intval($_POST['hdnIdPedido']) : null;
$totalCobro = isset($_POST['hdnTotal']) ? floatval($_POST['hdnTotal']) : null;

// Variable estandarizada al estilo de tu compañero ($objControl)
$objControl = new GetPagar();

// FILTRO 1: image_06eac9.png -> "Error. Acción no permitida"
if (!$objControl->validarBoton($boton)) 
{
    include_once('../shared/mensajeSistemaBox.php');
    $objMensaje = new mensajeSistemaBox();  
    $objMensaje->mensajeSistemaBoxShow("Error. Acción no permitida", "<a href='formRealizarCobro.php'>Regresar al inicio</a>");
}
else 
{
    // FILTRO 2: image_06eac9.png -> "Error. Transacción denegada"
    if (!$objControl->validarPrivilegio()) 
    {
        include_once('../shared/mensajeSistemaBox.php');
        $objMensaje = new mensajeSistemaBox();  
        $objMensaje->mensajeSistemaBoxShow("Error. Transacción denegada", "<a href='formRealizarCobro.php'>Regresar</a>");
    }
    else 
    {
        // CAPA CONTROLADOR: Instanciamos el controlador del caso de uso en vez de la factura directo
        $objControladorCasoUso = new controllerRealizarCobro();
        // Ejecutamos la segunda operación formal declarada en tu diagrama de clases de Rose
        $exito = $objControladorCasoUso->actualizarEstadoFactura($idPedido, $totalCobro);

        if (!$exito) 
        {
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();  
            $objMensaje->mensajeSistemaBoxShow("Error al registrar el comprobante", "<a href='formRealizarCobro.php'>Reintentar</a>");
        }
        else 
        {
            if (session_status() === PHP_SESSION_NONE) { session_start(); }
            
            // Estructuramos la data que pide la nota del diagrama de actividades para la impresión
            $_SESSION['factura_impresa'] = [
                'idFactura' => 'F001-' . rand(1000, 9999),
                'txtMesa' => $_SESSION['nro_mesa_actual'],
                'txtFecha' => date('Y-m-d'),
                'pedidoDetalle' => 'Consumo general de alimentos y bebidas',
                'txtTotalAPagar' => number_format($totalCobro, 2),
                'estadoPedido' => 'Pagado'
            ];

            // Redireccionamos de vuelta a la vista para que el enrutador inteligente dibuje formImprimirFactura()
            header("Location: formRealizarCobro.php");
            exit();
        }
    }
}
?>