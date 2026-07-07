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
        public function obtenerPedidoDeMesa($idMesa, $idUsuario)
        {
            include_once('../modelo/pedido.php');
            $objPedido = new pedido();
            $idPedido = $objPedido -> obtenerPedidoVigenteDeMesa($idMesa);
            if ($idPedido == null) {
                $idPedido = $objPedido -> crearPedidoDeMesa($idMesa, $idUsuario);
            }
            return $idPedido;
        }
        public function obtenerPlatosEnPedido($idPedido)
        {
            include_once('../modelo/platoPedido.php');
            $objPlatoPedido = new platoPedido();
            $platosPedido = $objPlatoPedido -> obtenerPlatosEnPedido($idPedido);
            return $platosPedido;
        }
        public function cancelarPlatoEnPedido($idPlatoPedido)
        {
            include_once('../modelo/platoPedido.php');
            $objPlatoPedido = new platoPedido();
            $respuesta = $objPlatoPedido -> cancelarPlatoEnPedido($idPlatoPedido);
            if (!($respuesta)) {
                include_once('../shared/mensajeSistemaBox.php');
                $objMensaje = new mensajeSistemaBox();
                $objMensaje -> mensajeSistemaBoxShow("ERROR: No se pudo cancelar el plato","<a href='../moduloPedidos/indexPedido.php'>volver</a>");
            }
        }
        public function entregarPlatoPedido($idPedido)
        {
            include_once('../modelo/platoPedido.php');
            $objPlatoPedido = new platoPedido();
            $respuesta = $objPlatoPedido -> entregarPlatoPedido($idPedido);
            if (!($respuesta)) {
                include_once('../shared/mensajeSistemaBox.php');
                $objMensaje = new mensajeSistemaBox();
                $objMensaje -> mensajeSistemaBoxShow("ERROR: No se pudo entregar el plato","<a href='../moduloPedidos/indexPedido.php'>volver</a>");
            }
        }
        public function obtenerCategorias()
        {
            include_once('../modelo/categoria.php');
            $objCategoria = new categoria();
            $categorias = $objCategoria -> obtenerCategorias();
            return $categorias;
        }
        public function obtenerPlatosEnCategoria($idCategoria)
        {
            include_once('../modelo/plato.php');
            $objPlato = new plato();
            $platosCategoria = $objPlato -> obtenerPlatosEnCategoria($idCategoria);
            return $platosCategoria;
        }
        public function agregarPlatoAPedido($idPlato, $idPedido)
        {
            include_once('../modelo/platoPedido.php');
            $objPlatoPedido = new platoPedido();
            $respuesta = $objPlatoPedido -> agregarPlatoAPedido($idPlato, $idPedido);
            if (!($respuesta)) {
                include_once('../shared/mensajeSistemaBox.php');
                $objMensaje = new mensajeSistemaBox();
                $objMensaje -> mensajeSistemaBoxShow("ERROR: No se pudo agregar el plato al pedido","<a href='../moduloPedidos/indexPedido.php'>volver</a>");
            }
        }
    }