<?php
include_once('conexion.php');

class insumo extends conexion
{
    public function obtenerStock()
    {
        // Unimos DB_Insumo con DB_Lote para poder mostrar el nombre del producto
        $consulta = "SELECT i.DB_Insumo_ID as id_insumo, 
                            i.codInsumo as codigo, 
                            l.nombreProducto as nombre, 
                            i.stock as cantidad 
                     FROM DB_Insumo i
                     INNER JOIN DB_Lote l ON i.DB_Lote_ID = l.DB_Lote_ID";
                     
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

    // Adaptado a las columnas reales: codInsumo, stock, DB_Lote_ID
    public function enviarInsumo($codInsumo, $stock, $loteId)
    {
        $consulta = "INSERT INTO DB_Insumo (codInsumo, stock, DB_Lote_ID) 
                     VALUES ('$codInsumo', '$stock', '$loteId')";
        $conexion = $this->conectarBD();
        $resultado = pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
        return $resultado;
    }

    public function actualizarStock($id, $cantidad)
    {
        // Actualizamos según la llave primaria correcta
        $consulta = "UPDATE DB_Insumo SET stock = '$cantidad' WHERE DB_Insumo_ID = '$id'";
        $conexion = $this->conectarBD();
        $resultado = pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
        return $resultado;
    }
}
?>