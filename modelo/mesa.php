<?php
    include_once('conexion.php');
    class mesa extends conexion
    {
        public function obtenerMesasDisponibles()
        {
            $sql = "SELECT 
                        me.db_mesa_id as idmesa,
                        me.numero as nromesa,
                        EXISTS (
                            SELECT 1
                            FROM db_pedido pe
                            INNER JOIN db_platopedido pp ON pp.db_pedido_id = pe.db_pedido_id
                            WHERE pe.db_mesa_id = me.db_mesa_id
                            AND pp.estado = 'listo'
                        ) AS platolisto
                    FROM db_mesa me
                    WHERE me.disponible = true;";
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $sql);
            $this->desconectarBD($conexion);
            $mesasDisponibles = [];
            while($fila = pg_fetch_assoc($resultado))
            {
                $mesasDisponibles[] = $fila;
            }
            return $mesasDisponibles;
        }
    }