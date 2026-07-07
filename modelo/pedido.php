<?php
    include_once('conexion.php');
    class pedido extends conexion
    {
        public function obtenerPedidoVigenteDeMesa($idMesa)
        {
            $consulta =    "SELECT db_pedido_id as idpedido FROM db_pedido
                            WHERE estado = 'pendiente' AND db_mesa_id = '$idMesa';";    
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
            $consultaInsertarPedido =      "INSERT INTO db_pedido (codpedido, fecha, total, estado, observacion, db_mesa_id, db_usuario_id)
                                            VALUES (9999, CURRENT_DATE, 0, 'pendiente', '', $idMesa, $idUsuario);";
            $consultaObtenerIdPedido =     "SELECT db_pedido_id FROM db_pedido WHERE codpedido = 9999;";
            $consultaActualizarCodigo =    "UPDATE db_pedido SET codpedido = db_pedido_id + 5000 WHERE codpedido = 9999;";
            
            $conexion = $this->conectarBD();
            pg_query($conexion, $consultaInsertarPedido);
            $resultado = pg_query($conexion, $consultaObtenerIdPedido);
            pg_query($conexion, $consultaActualizarCodigo);
            $this->desconectarBD($conexion);
            
            $idPedido = pg_fetch_result($resultado, 0, 'db_pedido_id');
            
            return $idPedido;
        }
    }