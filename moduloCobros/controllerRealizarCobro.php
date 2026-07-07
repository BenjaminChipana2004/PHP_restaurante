<?php
class controllerRealizarCobro
{
    /**
     * Operación 1: Invoca al modelo pedido para buscar los consumos de la mesa.
     */
    public function obtenerPedidoDetalle($NroMesa)
    {
        include_once('../modelo/pedido.php');
        $objModelo = new pedido();
        $pedidoEncontrado = $objModelo->obtenerPedidoDetalle($NroMesa);
        return $pedidoEncontrado;
    }

    /**
     * Operación 2: Invoca al modelo factura para registrar el pago y cerrar la cuenta.
     */
    public function actualizarEstadoFactura($idPedido, $totalCobro)
    {
        include_once('../modelo/factura.php');
        $objModelo = new Factura();
        $exito = $objModelo->actualizarEstadoFactura($idPedido, $totalCobro);
        return $exito;
    }
}
?>