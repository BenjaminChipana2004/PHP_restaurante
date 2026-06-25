<?php
include_once('conexion.php');

class Plato extends Conexion
{
    function obtenerPlatosCocina()
    {
        $conexion = $this->conectarBD();
        $consulta = "SELECT PP.codplatopedido AS idPlato, P.nombre, P.imagenUrl, PP.estado 
                     FROM db_plato P 
                     INNER JOIN db_platopedido PP ON PP.db_plato_id = P.db_plato_id
                     WHERE PP.estado = 'pendiente' OR PP.estado = 'enCocina';";
                     
        $respuesta = pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
        $platosCocina = [];
        while($fila = pg_fetch_assoc($respuesta))
        {
            $platosCocina[] = $fila;
        }
        return $platosCocina;
    }

    function cancelarPlato($idPlato)
    {
        $conexion = $this->conectarBD();
        $consulta = "UPDATE db_platopedido SET estado = 'cancelado' WHERE codplatopedido = $idPlato;";
        pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
    }

    function enviarPlatoCocina($idPlato)
    {
        $conexion = $this->conectarBD();
        $consulta = "UPDATE db_platopedido SET estado = 'enCocina' WHERE codplatopedido = $idPlato;";
        pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
    }

    function entregarPlato($idPlato)
    {
        $conexion = $this->conectarBD();
        $consulta = "UPDATE db_platopedido SET estado = 'entregado' WHERE codplatopedido = $idPlato;";
        pg_query($conexion, $consulta);
        $this->desconectarBD($conexion);
    }
}