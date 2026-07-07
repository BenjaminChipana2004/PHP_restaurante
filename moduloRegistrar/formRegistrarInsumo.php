<?php
include_once("../shared/pantalla.php");

class formRegistrarInsumo extends pantalla
{
    public function formRegistrarInsumoShow($listaInsumos, $verFormulario = false)
    {
        $this->cabeceraShow("Registrar Insumos - Restaurante");
        ?>
        <h2 align="center">GESTIÓN DE INSUMOS DEL RESTAURANTE</h2>

        <table align="center" border="1" cellpadding="5" cellspacing="0" style="width: 70%; text-align: center;">
            <tr style="background-color: #cccccc;">
                <th>ID PRODUCTO</th>
                <th>NOMBRE DEL INSUMO</th>
                <th>CANTIDAD / UNIDADES</th>
                <th>CATEGORÍA</th>
            </tr>
            <?php
            if ($listaInsumos == NULL) {
                echo "<tr><td colspan='4'>No hay insumos registrados en el sistema.</td></tr>";
            } else {
                foreach ($listaInsumos as $insumo) {
                    ?>
                    <tr>
                        <td><?php echo $insumo['id_insumo']; ?></td>
                        <td><?php echo $insumo['nombre']; ?></td>
                        <td><?php echo $insumo['cantidad']; ?></td>
                        <td><?php echo $insumo['categoria']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>

        <br><br>

        <?php if (!$verFormulario) { ?>
            <center>
                <form method="POST" action="">
                    <input type="hidden" name="btnRegistrarInsumoInicio" value="true">
                    <input type="submit" name="btnMostrarFormulario" value="Agregar Nuevo Insumo" style="padding: 10px 20px; font-weight: bold;">
                </form>
            </center>
            <?php
            // Si el usuario le dio click a "Agregar Nuevo Insumo", recargamos mostrando el formulario
            if (isset($_POST['btnMostrarFormulario'])) {
                echo "<script>window.location.href = window.location.href;</script>";
                $this->formRegistrarInsumoShow($listaInsumos, true);
                return;
            }
        } else { ?>
            <form method="POST" action="getRegistrarInsumo.php">
                <table align="center" border="0" style="background-color: #f9f9f9; padding: 15px; border: 1px solid #ddd;">
                    <tr>
                        <td colspan="2" align="center" style="font-weight: bold; padding-bottom: 10px;">NUEVO INSUMO</td>
                    </tr>
                    <tr>
                        <td>ID Insumo:</td>
                        <td><input type="text" name="txtIdInsumo" required /></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><input type="text" name="txtNombre" required /></td>
                    </tr>
                    <tr>
                        <td>Cantidad / Unidades:</td>
                        <td><input type="number" name="txtCantidad" min="1" required /></td>
                    </tr>
                    <tr>
                        <td>Categoría:</td>
                        <td>
                            <select name="txtCategoria">
                                <option value="Carnes">Carnes</option>
                                <option value="Verduras">Verduras</option>
                                <option value="Abarrotes">Abarrotes</option>
                                <option value="Bebidas">Bebidas</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" style="padding-top: 15px;">
                            <input type="submit" name="btnRegistrarInsumo" value="Registrar Ahora" />
                        </td>
                    </tr>
                </table>
            </form>
        <?php } ?>

        <?php
        $this->piePaginaShow();
    }
}
?>