<?php
    include_once("../shared/pantalla.php");
    class formRegistrarDespacho extends pantalla
    {
        public function formRegistrarDespachoShow($platosCocina)
        {
            $this->cabeceraShow("Registrar Despacho");
            $numeroPlatos = count($platosCocina);
            ?>
            <div class="panel-cocina-container">
                <h2 class="titulo-seccion pending-color">Platos pendientes</h2>
                <div class="grid-platos">
            <?php
            $tieneItemsPendientes = false;
            for($i = 0; $i < $numeroPlatos; $i++)
            {
                if($platosCocina[$i]['estado'] == "pendiente")
                {
                    $tieneItemsPendientes = true;
                    ?>
                    <div class="tarjeta-plato card-pendiente">
                        <div class="imagen-contenedor">
                            <img src="<?php echo $platosCocina[$i]['imagenurl'];?>" alt="<?php echo $platosCocina[$i]['nombre'];?>" class="img-plato">
                        </div>
                        <div class="info-plato">
                            <h3><?php echo $platosCocina[$i]['nombre'];?></h3>
                            <span class="badge badge-pendiente">Pendiente</span>
                        </div>
                        <form method="POST" action="../moduloVentas/getEstadoPlato.php" class="form-acciones">
                            <input type="hidden" name="idPlato" value="<?php echo $platosCocina[$i]['idplato'];?>">
                            <input type="submit" name="btnPlato" class="btn btn-rojo" value="cancelar">
                            <input type="submit" name="btnPlato" class="btn btn-verde" value="enCocina">
                        </form>
                    </div>
                    <?php
                }
            }
            if(!$tieneItemsPendientes) {
                ?><p class="vacio-msg">No hay platos pendientes</p><?php
            }
            ?>
                </div>

                <h2 class="titulo-seccion kitchen-color">Platos en cocina</h2>
                <div class="grid-platos">
            <?php
            $tieneItemsEnCocina = false;
            for($i = 0; $i < $numeroPlatos; $i++)
            {
                if($platosCocina[$i]['estado'] == "enCocina")
                {
                    $tieneItemsEnCocina = true;
                    ?>
                    <div class="tarjeta-plato card-encocina">
                        <div class="imagen-contenedor">
                            <img src="<?php echo $platosCocina[$i]['imagenurl'];?>" alt="<?php echo $platosCocina[$i]['nombre'];?>" class="img-plato">
                        </div>
                        <div class="info-plato">
                            <h3><?php echo $platosCocina[$i]['nombre'];?></h3>
                            <span class="badge badge-encocina">En Cocina</span>
                        </div>
                        <form method="POST" action="../moduloVentas/getEstadoPlato.php" class="form-acciones">
                            <input type="hidden" name="idPlato" value="<?php echo $platosCocina[$i]['idplato'];?>">
                            <input type="submit" name="btnPlato" class="btn btn-rojo" value="cancelar">
                            <input type="submit" name="btnPlato" class="btn btn-verde" value="entregado">
                        </form>
                    </div>
                    <?php
                }
            }
            if(!$tieneItemsEnCocina) {
                ?><p class="vacio-msg">No hay platos en cocina</p><?php
            }
            ?>
                </div>
            </div>
            <?php
            $this->piePaginaShow();
        }
    }