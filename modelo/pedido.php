<?php
require_once 'conexion.php';

class Pedido extends Conexion
{
    /**
     * Obtiene el detalle de un pedido activo para una mesa específica.
     * Cumple exactamente con la función declarada en el Rational Rose.
     */
    public function obtenerPedidoDetalle($NroMesa)
    {
        // Abrimos la conexión heredada de la clase Conexion
        $db = $this->conectarBD();

        // CORRECCIÓN: Agregamos "AS db_pedido_id" para que coincida exactamente con la vista en minúsculas
        $sql = "SELECT p.DB_Pedido_ID AS db_pedido_id, p.codPedido, p.total 
                FROM DB_Pedido p
                INNER JOIN DB_Mesa m ON p.DB_Mesa_ID = m.DB_Mesa_ID
                WHERE m.numero = $1 AND p.estado = 'entregado' 
                LIMIT 1;";

        // Ejecutamos la consulta pasando el parámetro exacto NroMesa
        $result = pg_query_params($db, $sql, array($NroMesa));

        // Si ocurre un error en la consulta, cerramos la BD y retornamos falso
        if (!$result) {
            $this->desconectarBD($db);
            return false;
        }

        // Extraemos la fila encontrada como un arreglo asociativo
        $pedido = pg_fetch_assoc($result);

        // Cerramos la conexión siempre al terminar
        $this->desconectarBD($db);

        // Retorna los datos del pedido o false si no hay nada
        return $pedido;
    }
}
?>