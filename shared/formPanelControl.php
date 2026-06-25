<?php
    include_once("../shared/pantalla.php");
    class formPanelControl extends pantalla
    {
        public function formPanelControlShow($listaPrivilegios)
        {
            $titulo = "Bienvenido/a " . $_SESSION['nombre'];
            $this -> cabeceraShow($titulo);
            $numeroPrivilegios = count($listaPrivilegios);
            ?>
            <div class="panel-cocina-container">
                <h2 class="titulo-seccion" style="color: #2c3e50;">Selecciona una opción</h2>
                <div class="grid-platos" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
            <?php
            for($i = 0; $i < $numeroPrivilegios; $i++)
            {
            ?>
                    <form method="POST" action="../shared/getCasoUso.php" style="display: 100%;">
                        <input type="submit" name="btnCasoUso" class="btn btn-azul" value="<?php echo $listaPrivilegios[$i];?>" style="width: 100%; margin: 0;">
                    </form>
            <?php
            }
            ?>
                </div>
            </div>
            <?php
            $this -> piePaginaShow();
        }
    }
?>