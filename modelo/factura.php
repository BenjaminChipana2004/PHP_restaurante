<?php
require_once 'conexion.php';

class Factura extends Conexion
{
    /**
     * Registra la factura en el sistema y actualiza el estado del pedido a 'pagado'.
     * Evita errores en cabecera controlando duplicados de forma transparente.
     */
    public function actualizarEstadoFactura($idPedido, $totalCobro)
    {
        // Abrimos la conexión heredada de la clase Conexion
        $db = $this->conectarBD();

        // Ocultamos advertencias locales crudas de la BD para que no se pinten en la cabecera web
        $antiguoNivelError = error_reporting(0);

        // Iniciamos una transacción para asegurar la integridad de los datos
        pg_query($db, "BEGIN");

        // 1. Calculamos los montos financieros de forma automática
        $igv = $totalCobro * 0.18;
        $subtotal = $totalCobro - $igv;
        
        // Generamos un número correlativo aleatorio para la simulación de número de boleta
        $numeroFactura = rand(1000, 9999); 

        // 2. Insertamos el registro usando ON CONFLICT para ignorar duplicados de forma segura
        $sqlFactura = "INSERT INTO db_factura (serie, numero, fecha, subtotal, igv, total, db_pedido_id) 
                       VALUES ('F001', $1, CURRENT_DATE, $2, $3, $4, $5)
                       ON CONFLICT (db_pedido_id) DO NOTHING;";
        
        $resFactura = pg_query_params($db, $sqlFactura, array($numeroFactura, $subtotal, $igv, $totalCobro, $idPedido));

        if (!$resFactura) {
            pg_query($db, "ROLLBACK"); // Cancelamos si ocurre un error real de sintaxis o conexión
            error_reporting($antiguoNivelError); // Restauramos errores antes de salir
            $this->desconectarBD($db);
            return false;
        }

        // 3. Forzamos que el estado del pedido pase a 'pagado' (Incluso si la factura ya se había creado antes)
        $sqlPedido = "UPDATE db_pedido 
                      SET estado = 'pagado' 
                      WHERE db_pedido_id = $1;";

        $resPedido = pg_query_params($db, $sqlPedido, array($idPedido));

        if (!$resPedido) {
            pg_query($db, "ROLLBACK"); // Cancelamos todo si falla
            error_reporting($antiguoNivelError);
            $this->desconectarBD($db);
            return false;
        }

        // Si todo marchó bien, consolidamos la transacción en la BD
        pg_query($db, "COMMIT");

        // Restauramos el nivel de errores original de PHP de forma limpia
        error_reporting($antiguoNivelError);

        // Cerramos la conexión siempre al finalizar de forma limpia
        $this->desconectarBD($db);
        return true;
    }
}
?>