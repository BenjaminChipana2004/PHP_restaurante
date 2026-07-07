<?php
    include_once('conexion.php');
    class platoPedido extends conexion
    {
        public function obtenerPlatosEnPedido($idPedido){
            $consulta =    "SELECT pl.nombre, pl.imagenUrl, pp.DB_PlatoPedido_ID AS idplatopedido, pp.precioUnitario, pp.estado, pe.total 
                            FROM DB_PlatoPedido pp
                            INNER JOIN DB_Plato pl ON pp.DB_Plato_ID = pl.DB_Plato_ID
                            INNER JOIN DB_Pedido pe ON pp.DB_Pedido_ID = pe.DB_Pedido_ID
                            WHERE pe.db_pedido_id = $idPedido;";
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            if ($resultado && pg_num_rows($resultado) > 0) {
                $platosPedido = array();
                while ($fila = pg_fetch_assoc($resultado)) {
                    $platosPedido[] = $fila;
                }
            } else {
                $platosPedido = null; 
            }
            return $platosPedido;
        }
        public function cancelarPlatoEnPedido($idPlatoPedido){
            $consulta = "UPDATE db_platopedido SET estado = 'cancelado' WHERE db_platopedido_id = $idPlatoPedido;";
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            return $resultado;
        }
        public function entregarPlatoPedido($idPlatoPedido){
            $consulta = "UPDATE db_platopedido SET estado = 'entregado' WHERE db_platopedido_id = $idPlatoPedido;";
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            return $resultado;
        }
        public function agregarPlatoAPedido($idPlato, $idPedido){
            $consulta =    "INSERT INTO DB_PlatoPedido (codPlatoPedido, DB_Plato_ID, DB_Pedido_ID, precioUnitario, estado)
                            VALUES (1111, $idPlato, $idPedido, 
                            (SELECT precio FROM DB_Plato WHERE DB_Plato_ID = $idPlato),
                            'pendiente');
                            UPDATE db_platopedido SET codplatopedido = db_platopedido_id + 9000 WHERE codplatopedido = 1111;
                            UPDATE DB_Pedido SET total = (
                                SELECT SUM(precioUnitario)
                                FROM DB_PlatoPedido
                                WHERE DB_PlatoPedido.DB_Pedido_ID = DB_Pedido.DB_Pedido_ID)
                            WHERE DB_Pedido_ID = $idPedido;";
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            return $resultado;
        }
    }