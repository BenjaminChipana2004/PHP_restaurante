<?php
    include_once('conexion.php');
    class categoria extends conexion
    {
        function obtenerCategorias()
        {
            $consulta = "SELECT db_categoria_id as idcategoria, nombre FROM db_categoria;";
            $conexion = $this -> conectarBD();
            $respuesta = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            $categorias = [];
            while($fila = pg_fetch_assoc($respuesta))
            {
                $categorias[] = $fila;
            }
            return $categorias;
        }
    }