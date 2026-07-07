<?php
    include_once('../shared/pantalla.php');
    class formRegistrarPedido extends pantalla
    {
        public function formMesasDisponiblesShow($mesasDisponibles)
        {
            $titulo = "Registrar Pedido";
            $this -> cabeceraShow($titulo);
            ?>
                <h1>Registrar Pedido</h1>
                <p>Mesas con platos listos: 🟢</p>
                <p>Mesas con platos listos: ⚪</p>
            <?php
            foreach($mesasDisponibles as $mesa)
            {
                $color_boton = ($mesa['platolisto'] == true) ? '#28a745' : '#ffffff';
                ?>
                    <form method="POST" action="../moduloPedidos/getMesa.php">
                        <input type="hidden" name="idMesa" value="<?php echo $mesa['idmesa'];?>">   
                        <input type="hidden" name="nroMesa" value="<?php echo $mesa['nromesa'];?>">
                        <button type="submit" name="boton" value="mesa" class="btn btn-mesa" 
                        style="background-color: <?php echo $color_boton; ?>;">Mesa</button>
                    </form>
                <?php
            }
            ?>
                <hr>
                <form method="POST" action="../moduloPedidos/getMesa.php">
                    <button type="submit" name="boton" value="volver" class="btn btn-mesa">Volver</button>
                </form>
            <?php
            $this -> piePaginaShow();
        }
        public function formListaPedidosShow($nroMesa, $platosPedido)
        {
            $titulo = "Pedido de la Mesa $nroMesa";
            $this -> cabeceraShow($titulo);
            ?>
                <h1>Registrar Pedido</h1>
                <h2>Mesa: <?php echo $nroMesa; ?></h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre del Plato</th>
                            <th>Imagen</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($platosPedido !== null) {
                                foreach ($platosPedido as $plato) {
                                    switch($plato['estado']) {
                                        case 'pendiente':
                                            $plato['estado'] = 'Pendiente';
                                            break;
                                        case 'enCocina':
                                            $plato['estado'] = 'En Cocina';
                                            break;
                                        case 'entregado':
                                            $plato['estado'] = 'Entregado';
                                            break;
                                        case 'cancelado':
                                            $plato['estado'] = 'Cancelado';
                                            break;
                                        case 'listo':
                                            $plato['estado'] = 'Listo';
                                            break;
                                        default:
                                            $plato['estado'] = 'Desconocido';
                                            break;
                                    }
                                    ?>
                                        <form method="POST" action="../moduloPedidos/getPedido.php">
                                            <tr>
                                                <td><?php echo htmlspecialchars($plato['nombre']); ?></td>
                                                <td><img src="<?php echo htmlspecialchars($plato['imagenurl']); ?>" alt="Imagen del Plato" width="100"></td>
                                                <td>S/<?php echo htmlspecialchars($plato['preciounitario']); ?></td>
                                                <td><?php echo htmlspecialchars($plato['estado']); ?></td>
                                                <td><button type="submit" name="boton" value="entregar" class="btn btn-primary"
                                                <?php if ($plato['estado'] !== 'Listo') { echo 'disabled'; } ?>>
                                                >Entregar</button></td>
                                                <td><button type="submit" name="boton" value="cancelar" class="btn btn-danger"
                                                <?php if ($plato['estado'] !== 'Pendiente') { echo 'disabled'; } ?>>
                                                >Cancelar</button></td>
                                                <input type="hidden" name="idPlatoPedido" value="<?php echo htmlspecialchars($plato['idplatopedido']); ?>">
                                            </tr>
                                        </form>
                                    <?php
                                }
                            } else {
                                ?>
                                    <tr>
                                        <td colspan="4">No hay platos en este pedido.</td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                <hr>
                <form method="POST" action="../moduloPedidos/getPedido.php">
                    <button type="submit" name="boton" value="agregar plato" class="btn btn-mesa">Agregar Plato</button>
                </form>
                <form method="POST" action="../moduloPedidos/getPedido.php">
                    <button type="submit" name="boton" value="volver" class="btn btn-mesa">Volver</button>
                </form>
            <?php
            $this -> piePaginaShow();
        }
        public function formCategoriasPlatosShow($categorias)
        {
            $titulo = "Categorias";
            $this -> cabeceraShow($titulo);
            ?>
                <h1>Categorias</h1>
                <div class="categorias-container">
                    <?php
                        foreach($categorias as $categoria)
                        {
                            ?>
                                <form method="POST" action="../moduloPedidos/getCategoria.php">
                                    <input type="hidden" name="idCategoria" value="<?php echo $categoria['idcategoria'];?>">
                                    <button type="submit" name="boton" value="categoria" class="btn btn-categoria"><?php echo $categoria['nombre'];?></button>
                                </form>
                            <?php
                        }
                    ?>
                </div>
                <hr>
                <form method="POST" action="../moduloPedidos/getCategoria.php">
                    <button type="submit" name="boton" value="volver" class="btn btn-mesa">Volver</button>
                </form>
            <?php
        }
        public function formPlatosDisponiblesShow($platosCategoria)
        {
            $titulo = "Platos Disponibles";
            $this -> cabeceraShow($titulo);
            ?>
                <h1>Platos Disponibles</h1>
                <div class="platos-container">
                    <?php
                        foreach($platosCategoria as $plato)
                        {
                            ?>
                                <div class="plato-card">
                                    <h3><?php echo $plato['nombre'];?></h3>
                                    <img src="<?php echo $plato['imagenurl'];?>" alt="Imagen del Plato" width="150">
                                    <p>Precio: S/<?php echo $plato['precio'];?></p>
                                    <form method="POST" action="../moduloPedidos/getPlato.php">
                                        <input type="hidden" name="idPlato" value="<?php echo $plato['idplato'];?>">
                                        <button type="submit" name="boton" value="agregar" class="btn btn-primary">Agregar al Pedido</button>
                                    </form>
                                </div>
                            <?php
                        }
                    ?>
                </div>
                <hr>
                <form method="POST" action="../moduloPedidos/getPlato.php">
                    <button type="submit" name="boton" value="volver" class="btn btn-mesa">Volver</button>
                </form>
            <?php
            $this -> piePaginaShow();
        }

    }