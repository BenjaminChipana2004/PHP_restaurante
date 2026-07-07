<?php
    include_once("../shared/pantalla.php");

    class formAgregarUsuario extends pantalla
    {
        public function formCrearNuevoUsuario()
        {
            $this->cabeceraShow("Crear Nuevo Usuario");
            ?>
            <!-- Ajustado el action para que procese en el mismo directorio del módulo -->
            <form method="POST" action="getAgregarUsuario.php">
                <table align="center" border="0" style="margin-top: 30px; background-color: #f9f9f9; padding: 20px; border-radius: 8px;">
                    <tr>
                        <td colspan="2" align="center" style="font-weight: bold; font-size: 1.2em; padding-bottom: 15px;">
                            CREAR NUEVO USUARIO
                        </td>
                    </tr>
                    <tr><td>Nombre:</td><td><input type="text" name="txtNombre" required/></td></tr>
                    <tr><td>Apellido:</td><td><input type="text" name="txtApellido" required/></td></tr>
                    <tr><td>DNI:</td><td><input type="text" name="txtDNI" maxlength="8" required/></td></tr>
                    <tr><td>Fecha Nacimiento:</td><td><input type="date" name="txtFechaNacimiento" required/></td></tr>
                    <tr><td>Correo:</td><td><input type="email" name="txtCorreo" required/></td></tr>
                    <tr><td>Contraseña:</td><td><input type="password" name="txtContrasena" required/></td></tr>
                    <tr>
                        <td>Rol:</td>
                        <td>
                            <!-- Mapeado con las llaves primarias numéricas de tu tabla DB_Rol -->
                            <select name="cboRol" required>
                                <option value="">Seleccione un rol...</option>
                                <option value="1">Cocinero</option>
                                <option value="3">Cajero</option>
                                <option value="2">Mesero</option>
                                <option value="4">Administrador</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" style="padding-top: 15px;">
                            <input type="submit" name="btnAgregar" value="Agregar" style="cursor:pointer; font-weight:bold;"/>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            $this->piePaginaShow();
        }
    }
?>
