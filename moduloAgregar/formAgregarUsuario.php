<?php
    include_once("../shared/pantalla.php");

    class formAgregarUsuario extends pantalla
    {
        public function formAgregarUsuarioShow()
        {
            $this->cabeceraShow("Agregar Nuevo Usuario");
            ?>
            <form method="POST" action="getAgregarUsuario.php">
                <table align="center" border="0" style="margin-top: 50px; background-color: #f4f4f4; padding: 20px; border-radius: 5px;">
                    <tr>
                        <td colspan="2" align="center" style="font-weight: bold; font-size: 1.2em; padding-bottom: 15px;">
                            REGISTRAR NUEVO USUARIO
                        </td>
                    </tr>
                    <tr>
                        <td>NUEVO LOGIN:</td>
                        <td><input type="text" name="txtNuevoLogin" placeholder="Ej. juan123" required/></td>
                    </tr>
                    <tr>
                        <td>PASSWORD:</td>
                        <td><input type="password" name="txtNuevoPassword" placeholder="Mínimo 4 caracteres" required/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" style="padding-top: 15px;">
                            <input type="submit" name="btnRegistrarUsuario" value="Guardar Usuario" style="cursor:pointer; font-weight:bold;"/>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            $this->piePaginaShow();
        }
    }
?>