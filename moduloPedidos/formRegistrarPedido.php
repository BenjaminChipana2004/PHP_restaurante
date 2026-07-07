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
                    <form action="POST" action="../moduloPedidos/getMesa.php">
                        <input type="hidden" name="idMesa" value="<?php echo $mesa['idmesa'];?>">   
                        <input type="hidden" name="nroMesa" value="<?php echo $mesa['nromesa'];?>">
                        <button type="submit" name="boton" value="mesa" class="btn btn-mesa" 
                        style="background-color: <?php echo $color_boton; ?>;">Mesa</button>
                    </form>
                <?php
            }
            ?>
                <hr>
                <form action="POST" action="../moduloPedidos/getMesa.php">
                    <button type="submit" name="boton" value="volver" class="btn btn-mesa">Volver</button>
                </form>
            <?php
        }
    }