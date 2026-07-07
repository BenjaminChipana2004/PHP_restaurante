<?php
include_once("../shared/pantalla.php");

class formRegistrarInsumo extends pantalla
{
    // Ya no necesitamos la variable $verFormulario
    public function formRegistrarInsumoShow($listaInsumos)
    {
        $this->cabeceraShow("Registrar Insumos - Restaurante");
        ?>
        <h2 align="center">GESTIÓN DE INSUMOS DEL RESTAURANTE</h2>

        <!-- 1. TABLA DE INVENTARIO -->
        <table align="center" border="1" cellpadding="5" cellspacing="0" style="width: 70%; text-align: center;">
            <tr style="background-color: #cccccc;">
                <th>ID INSUMO</th>
                <th>CÓDIGO</th>
                <th>NOMBRE DEL LOTE</th>
                <th>STOCK (CANTIDAD)</th>
            </tr>
            <?php
            if ($listaInsumos == NULL) {
                echo "<tr><td colspan='4'>No hay insumos registrados en el sistema.</td></tr>";
            } else {
                foreach ($listaInsumos as $insumo) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($insumo['id_insumo']); ?></td>
                        <td><?php echo htmlspecialchars($insumo['codigo']); ?></td>
                        <td><?php echo htmlspecialchars($insumo['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($insumo['cantidad']); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>

        <br><br>

        <!-- 2. BOTÓN PARA MOSTRAR FORMULARIO (Usa Javascript simple, sin recargar la página) -->
        <center>
            <button type="button" id="btnMostrarForm" 
                    onclick="document.getElementById('contenedorFormulario').style.display='block'; this.style.display='none';" 
                    style="padding: 10px 20px; font-weight: bold; cursor: pointer;">
                Agregar Nuevo Insumo
            </button>
        </center>

        <!-- 3. EL FORMULARIO (Inicia oculto con display:none) -->
        <div id="contenedorFormulario" style="display: none; margin-top: 20px;">
            <form method="POST" action="../moduloRegistrar/getRegistrarInsumo.php">
                <table align="center" border="0" style="background-color: #f9f9f9; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                    <tr>
                        <td colspan="2" align="center" style="font-weight: bold; padding-bottom: 15px; font-size: 1.2em;">
                            NUEVO INSUMO
                        </td>
                    </tr>
                    <tr>
                        <td>Código del Insumo:</td>
                        <td><input type="text" name="txtCodInsumo" required style="padding: 5px;"/></td>
                    </tr>
                    <tr>
                        <td>Stock (Cantidad inicial):</td>
                        <td><input type="number" step="0.01" name="txtStock" min="0.01" required style="padding: 5px;"/></td>
                    </tr>
                    <tr>
                        <td>ID del Lote asociado:</td>
                        <td>
                            <input type="number" name="txtLoteId" min="1" placeholder="Ej. 1" required style="padding: 5px;"/>
                            <br><small style="color: #666;">Debe existir previamente en DB_Lote</small>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" style="padding-top: 15px;">
                            <input type="submit" name="btnRegistrarInsumo" value="Registrar Ahora" style="padding: 8px 15px; font-weight: bold; cursor: pointer;"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <?php
        $this->piePaginaShow();
    }
}
?>