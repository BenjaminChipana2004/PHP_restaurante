<?php
class controllerRegistrarDespacho
{
    function obtenerPlatosCocina()
    {
        include_once('../modelo/plato.php');
        $objModelo = new plato();
        $platosCocina = $objModelo -> obtenerPlatosCocina();
        return $platosCocina;
    }
    function cancelarPlato($idPlato)
    {
        include_once('../modelo/plato.php');
        $objModelo = new plato();
        $objModelo -> cancelarPlato($idPlato);
    }
    function enviarPlatoCocina($idPlato)
    {
        include_once('../modelo/plato.php');
        $objModelo = new plato();
        $objModelo -> enviarPlatoCocina($idPlato);
    }
    function entregarPlato($idPlato)
    {
        include_once('../modelo/plato.php');
        $objModelo = new plato();
        $objModelo -> entregarPlato($idPlato);
    }
}