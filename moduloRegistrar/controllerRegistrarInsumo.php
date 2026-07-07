<?php
class ControllerRegistrarInsumo
{
    public function obtenerStock()
    {
        include_once('../modelo/insumo.php');
        $objInsumo = new insumo();
        return $objInsumo->obtenerStock();
    }

    public function enviarInsumo($id, $nombre, $cantidad, $categoria)
    {
        include_once('../modelo/insumo.php');
        $objInsumo = new insumo();
        return $objInsumo->enviarInsumo($id, $nombre, $cantidad, $categoria);
    }

    public function actualizarStock($id, $cantidad)
    {
        include_once('../modelo/insumo.php');
        $objInsumo = new insumo();
        return $objInsumo->actualizarStock($id, $cantidad);
    }
}
?>