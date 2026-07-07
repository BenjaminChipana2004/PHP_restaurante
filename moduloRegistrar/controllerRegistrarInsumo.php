<?php
// CORRECCIÓN: c minúscula respetada en la clase
class controllerRegistrarInsumo
{
    public function obtenerStock()
    {
        include_once('../modelo/insumo.php');
        $objInsumo = new insumo();
        return $objInsumo->obtenerStock();
    }

    public function enviarInsumo($nombre, $cantidad, $categoria)
    {
        include_once('../modelo/insumo.php');
        $objInsumo = new insumo();
        return $objInsumo->enviarInsumo($nombre, $cantidad, $categoria);
    }

    public function actualizarStock($id, $cantidad)
    {
        include_once('../modelo/insumo.php');
        $objInsumo = new insumo();
        return $objInsumo->actualizarStock($id, $cantidad);
    }
}
?>