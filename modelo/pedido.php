<?php
    include_once('conexion.php');
    class pedido extends conexion
    {
        public function obtenerPedidoVigenteDeMesa($idMesa)
        {
            $consulta =    "SELECT db_pedido_id as idpedido FROM db_pedido
                            WHERE estado = 'pendiente' AND db_mesa_id = $idMesa;";    
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            if ($resultado && pg_num_rows($resultado) > 0) {
                $idPedido = pg_fetch_result($resultado, 0, 'idpedido');
            } else {
                $idPedido = null; 
            }
            return $idPedido;
        }
        public function crearPedidoDeMesa($idMesa, $idUsuario)
        {
            $consultaCodigo =              "INSERT INTO db_pedido (codpedido, fecha, total, estado, observacion, db_mesa_id, db_usuario_id)
                                            VALUES (1111, CURRENT_DATE, 0, 'pendiente', '', $idMesa, $idUsuario);
                                            ";
            $pedirId = "SELECT db_pedido_id FROM db_pedido WHERE codpedido = 1111;";
            $consultaActualizarCodigo =    "UPDATE db_pedido SET codpedido = db_pedido_id + 5000 WHERE codpedido = 1111;";
            
            $conexion = $this->conectarBD();
            pg_query($conexion, $consultaCodigo);
            $resultado = pg_query($conexion, $pedirId);
            pg_query($conexion, $consultaActualizarCodigo);
            $this->desconectarBD($conexion);
            
            $idPedido = pg_fetch_result($resultado, 0, 'db_pedido_id');
            
            return $idPedido;
        }
        public function obtenerPedidoDetalle($NroMesa)
        {
            // Abrimos la conexión heredada de la clase Conexion
            $db = $this->conectarBD();

            // CORRECCIÓN: Agregamos "AS db_pedido_id" para que coincida exactamente con la vista en minúsculas
            $sql = "SELECT p.DB_Pedido_ID AS db_pedido_id, p.codPedido, p.total 
                    FROM DB_Pedido p
                    INNER JOIN DB_Mesa m ON p.DB_Mesa_ID = m.DB_Mesa_ID
                    WHERE m.numero = $1 AND p.estado = 'pendiente' 
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