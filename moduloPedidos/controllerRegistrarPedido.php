<?php
    class controllerRegistrarPedido
    {
        public function obtenerMesasDisponibles()
        {
            include_once('../modelo/mesa.php');
            $objMesa = new mesa();
            $mesasDisponibles = $objMesa -> obtenerMesasDisponibles();
            return $mesasDisponibles;
        }
        public function obtenerPlatosEnMesa($idMesa)
        {
            include_once('../modelo/pedido.php');
            $objPedido = new pedido();
            $idPedido = $objPedido -> obtenerPedidoVigenteDeMesa($idMesa);
            if ($idPedido == null) {
                if(session_status() === PHP_SESSION_NONE)
                {
                    session_start();
                }
                $idUsuario = $_SESSION['idUsuario'];
                $idPedido = $objPedido -> crearPedidoDeMesa($idMesa, $idUsuario);
            }
            // Me quedé hasta acá, la verdad es que no he dormido nada, necesito una siesta para acabar.
            // Cabe aclarar que dormí por las 4:30 am a pesar intentarlo a las 3:30.
            // igual me levantaré temprano para avanzar, apoyarlos y unir los diseños
            // si leen esto, tengan fe, si se puede
            // solo tengo el esqueleto de la aplicación, pero la IA lo estilizará
            // además, la idea es que funcione tal como marcamos en el diseño, no tanto que se vea bonito
            return $platosPedido;
        }
    }