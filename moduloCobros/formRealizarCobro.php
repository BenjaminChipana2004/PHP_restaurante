<?php
// Incluimos la clase padre compartida que maneja la estructura HTML (estilo de tu amigo)
include_once("../shared/pantalla.php");

class formRealizarCobro extends pantalla
{
    /**
     * Operación 1: formRealizarCobroShow()
     * Según tu Rational Rose: Renderiza la interfaz inicial para buscar la mesa.
     */
    public function formRealizarCobroShow()
    {
        $this->cabeceraShow("Realizar Cobro");
        ?>
        <div class="panel-cobros-container">
            <h2 class="titulo-seccion cobro-color">Buscar Cuenta de Mesa</h2>
            
            <div class="tarjeta-formulario card-busqueda">
                <form method="POST" action="../moduloCobros/getCobro.php" class="form-acciones-cobro">
                    <div class="grupo-control">
                        <label for="txtMesa">Número de Mesa </label>
                        <input type="number" id="txtMesa" name="txtMesa" class="input-texto" placeholder="Ej. 1" required>
                        <label for="txtFecha">Fecha Actual: </label>
                        <input type="text" id="txtFecha" name="txtFecha" value="<?php echo date('d-m-Y'); ?>" readonly style="padding: 5px; background-color: #e9ecef; border: 1px solid #ced4da; color: #495057; cursor: not-allowed; width: 120px;">
                    </div>
                    
                    <div class="botones-contenedor">
                        <a href="../index.php" class="btn btn-rojo text-center" style="text-decoration:none; display:inline-block; line-height:35px;">Cancelar</a>
                        <input type="submit" name="btnBuscarMesa" class="btn btn-verde" value="Buscar Mesa">
                    </div>
                </form>
            </div>
        </div>
        <?php
        $this->piePaginaShow();
    }

    /**
     * Operación 2: formProformaShow()
     * Según tu Rational Rose: Despliega los cálculos financieros antes del cobro final.
     */
    public function formProformaShow($pedido, $nroMesa)
    {
        $this->cabeceraShow("Proforma de Venta");
        
        // Operaciones para desglosar el total traído de la base de datos
        $totalAPagar = floatval($pedido['total']);
        $subtotal = $totalAPagar / 1.18; // Cálculo contable real hacia atrás
        $igv = $totalAPagar - $subtotal;
        ?>
        <div class="panel-cobros-container">
            <h2 class="titulo-seccion proforma-color">Proforma - Mesa N° <?php echo $nroMesa; ?></h2>
            
            <div class="tarjeta-detalle-pedido card-proforma" style="position: relative;">
                
                <div class="fecha-proforma-nota" style="position: absolute; top: 15px; right: 20px; font-weight: bold; color: #555;">
                    Fecha: <span id="txtFecha"><?php echo date('Y-m-d'); ?></span>
                </div>

                <div class="info-pedido-cabecera">
                    <h3>Pedido ID: #<?php echo $pedido['db_pedido_id']; ?></h3>
                    
                    <span class="badge badge-proforma" style="background-color: #ffc107; color: #000; padding: 6px 12px; border-radius: 4px; font-weight: bold; display: inline-block;">
                        Estado: Pendiente de Pago
                    </span>
                </div>

                <div class="detalle-items-cobro">
                    <p class="descripcion-consumo">
                        <strong>Detalle (pedidoDetalle):</strong> Consumo General de Alimentos y Bebidas (Mesa <?php echo $nroMesa; ?>)
                    </p>
                    
                    <table class="tabla-valores" style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                        <tr>
                            <td align="right"><strong>Subtotal:</strong></td>
                            <td align="right" style="padding-left:20px;">S/. <?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>IGV (18%):</strong></td>
                            <td align="right" style="padding-left:20px;">S/. <?php echo number_format($igv, 2); ?></td>
                        </tr>
                        <tr style="font-size: 1.2em; border-top: 2px solid #333;">
                            <td align="right"><strong>Total a Pagar (S/.):</strong></td>
                            <td align="right" style="padding-left:20px; color: #28a745;"><strong>S/. <?php echo number_format($totalAPagar, 2); ?></strong></td>
                        </tr>
                    </table>
                </div>

                <form method="POST" action="getPagar.php" class="form-acciones">
                    <input type="hidden" name="hdnIdPedido" value="<?php echo $pedido['db_pedido_id']; ?>">
                    <input type="hidden" name="hdnTotal" value="<?php echo $totalAPagar; ?>">
                    
                    <div class="botones-contenedor">
                        <a href="formRealizarCobro.php" id="btnCancelar" class="btn btn-rojo text-center" style="text-decoration:none; display:inline-block; line-height:35px;">Cancelar</a>
                        <input type="submit" id="btnConfirmarCobro" name="btnPagarFactura" class="btn btn-verde" value="Confirmar Cobro">
                    </div>
                </form>
            </div>
        </div>
        <?php
        $this->piePaginaShow();
    }
    public function formImprimirFactura($facturaData)
    {
        $this->cabeceraShow("Comprobante Emitido");
        ?>
        <style>
        @media print {
            .botones-contenedor, header, footer, .titulo-seccion {
                display: none !important;
            }
            .tarjeta-factura {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
        </style>

        <div class="panel-cobros-container">
            <h2 class="titulo-seccion factura-color">Comprobante de Pago Emitido</h2>
            
            <div class="tarjeta-factura card-comprobante" style="background:#fff; padding:30px; border:2px dashed #000; max-width:500px; margin: 0 auto; font-family: monospace;">
                <center>
                    <h3>RESTAURANTE BIEN TRABAJADO S.A.C.</h3>
                    <p>RUC: 20123456789</p>
                    <p>----------------------------------------</p>
                    <h4>BOLETA / FACTURA ELECTRÓNICA</h4>
                    <h5>Nro: <?php echo $facturaData['idFactura']; ?></h5>
                    <p>----------------------------------------</p>
                </center>
                
                <p><strong>Fecha Emisión:</strong> <?php echo $facturaData['txtFecha']; ?></p>
                <p><strong>Mesa Atendida:</strong> Mesa N° <?php echo $facturaData['txtMesa']; ?></p>
                <p><strong>Estado del Pedido:</strong> <span style="color:green; font-weight:bold;"><?php echo $facturaData['estadoPedido']; ?></span></p>
                
                <p>----------------------------------------</p>
                <p><strong>Detalle:</strong> <?php echo $facturaData['pedidoDetalle']; ?></p>
                <p>----------------------------------------</p>
                
                <h3 align="right">TOTAL PAGADO: S/. <?php echo $facturaData['txtTotalAPagar']; ?></h3>
                
                <center>
                    <p>----------------------------------------</p>
                    <p>¡Gracias por su preferencia!</p>
                    <p>Representación impresa de comprobante electrónico.</p>
                </center>
            </div>

            <div class="botones-contenedor" style="text-align:center; margin-top:30px;">
                <button id="btnCerrarVentana" class="btn btn-verde text-center" style="border:none; cursor:pointer; height:40px; width:260px; font-size:15px; font-weight:bold; background-color:#0056b3; color:white; border-radius:4px;">
                    Cerrar Ventana / Imprimir Factura
                </button>
            </div>
        </div>

        <script>
        // Capturamos el clic en el botón oficial del diagrama (btnCerrarVentana)
        document.getElementById('btnCerrarVentana').addEventListener('click', function() {
            // Mandamos la orden directa a la impresora del navegador
            window.print();

            // Retornamos al flujo de inicio limpiando la interfaz
            setTimeout(function() {
                window.location.href = "../shared/formRealizarCobro.php";
            }, 300);
        });
        </script>
        <?php
        $this->piePaginaShow();
    }
}

// =========================================================================
// ENRUTADOR INTERNO DE INTERFAZ (Garantiza el ciclo de vida visual)
// =========================================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$objPantalla = new formRealizarCobro();

// Caso A: Si getPagar.php procesó el pago, despacha la Operación 3 (Factura Impresa)
if (isset($_SESSION['factura_impresa'])) 
{
    $datosFactura = $_SESSION['factura_impresa'];
    unset($_SESSION['factura_impresa']); // Limpieza preventiva del estado
    $objPantalla->formImprimirFactura($datosFactura);
} 
// Caso B: Si getCobro.php validó la mesa con éxito, despacha la Operación 2 (Proforma)
elseif (isset($_GET['status']) && $_GET['status'] === 'PedidoEncontrado' && isset($_SESSION['pedido_actual'])) 
{
    $objPantalla->formProformaShow($_SESSION['pedido_actual'], $_SESSION['nro_mesa_actual']);
} 
// Caso C: Carga inicial por defecto
else 
{
    // Solo se ejecuta automáticamente aquí si el archivo es invocado de manera directa por la URL,
    // previniendo que se renderice doble cuando getCasoUso.php ya ejecutó el método.
    if (basename($_SERVER['SCRIPT_NAME']) === 'formRealizarCobro.php') {
        $objPantalla->formRealizarCobroShow();
    }
}
?>