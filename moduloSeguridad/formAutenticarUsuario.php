<?php
include_once("./shared/pantalla.php");

class formAutenticarUsuario extends pantalla {
    public function formShow() {
        $this->cabeceraShow("Iniciar Sesion");
        ?>
        <div class="login-card">
            <h2>Iniciar Sesión</h2>
            <p class="login-subtitle">Ingrese sus datos para acceder al sistema</p>
            
            <form method="POST" action="./moduloSeguridad/getUsuario.php">
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="text" name="txtCorreo" id="correo" placeholder="ejemplo@correo.com" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="txtContrasena" id="password" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="btn-ingresar" name="btnAceptar">Ingresar</button>
            </form>
        </div>

        <div class="autores-box">
            <h3>Equipo de Desarrollo</h3>
            <ul class="autores-list">
                <li>👨‍💻 Chipana Bandera, Benjamin Adriano</li>
                <li>👨‍💻 Mandujano, Wilfredo</li>
                <li>👨‍💻 Alfaro Mendoza, Jose Luis</li>
            </ul>
        </div>

        <?php
        $this->piePaginaShow();
    }
}
?>