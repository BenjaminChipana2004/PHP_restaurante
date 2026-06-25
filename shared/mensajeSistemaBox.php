<?php
    include_once('pantalla.php');
    class mensajeSistemaBox extends pantalla
    {
        public function mensajeSistemaBoxShow($mensaje,$enlace)
        {
            $this->cabeceraShow("MENSAJE DEL SISTEMA");
            ?>
            <center>MENSAJE DEL SISTEMA</center>
            <p align ="center">
                <?php echo $mensaje; ?>
            </p>
            <center><?php echo $enlace; ?></center>
            <?php
            $this->piePaginaShow();
        }
    }
?>