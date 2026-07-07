<?php
include_once('conexion.php');

class insumo extends conexion
{
    public function obtenerStock()
    {
        // Se adapta al formato exacto de tu conexión PostgreSQL
        $consulta = "SELECT id_insumo, nombre, cantidad, categoria FROM insumos";
        $conexion = $this->conectarBD();
        $respuesta = pg_query($conexion, $consulta);
        
        if (!$respuesta) {
            die("Error SQL: " . pg_last_error($conexion));
        }
        
        $numfilas = pg_num_rows($respuesta);
        $this->desconectarBD($conexion);

        if ($numfilas == 0) {
            return NULL;
        } else {
            $vector = array();
            for ($i = 0; $i < $numfilas; $i++) {
                $vector[$i] = pg_fetch_array($respuesta, $i, PGSQL_ASSOC);
            }
            return $vector;
        }
    }

    public function enviarInsumo($id, $nombre, $cantidad, $categoria)
    {
        $consulta = "INSERT INTO insumos (id_insumo, nombre, cantidad, categoria) 
                     VALUES ('$id', '$nombre', '$cantidad', '$categoria')";
        $conexion = $this->conectarBD();
        $resultado = pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
        return $resultado;
    }

    public function actualizarStock($id, $cantidad)
    {
        $consulta = "UPDATE insumos SET cantidad = '$cantidad' WHERE id_insumo = '$id'";
        $conexion = $this->conectarBD();
        $resultado = pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
        return $resultado;
    }
}
?>
