<?php
    class ControllerAgregarUsuario
    {
        public function mostrarFormulario()
        {
            include_once('formAgregarUsuario.php');
            $objForm = new formAgregarUsuario();
            $objForm->formCrearNuevoUsuario();
        }

        public function consultaDNI($dni)
        {
            include_once('../modelo/usuario.php');
            $objUsuario = new usuario();
            return $objUsuario->consultaDNI($dni);
        }

        public function crearNuevoUsuario($nombre, $apellido, $dni, $fecha, $correo, $contrasena, $rol)
        {
            include_once('../modelo/usuario.php');
            $objUsuario = new usuario();
            $resultado = $objUsuario->crearNuevoUsuario($nombre, $apellido, $dni, $fecha, $correo, $contrasena, $rol);
            
            include_once('../shared/mensajeSistemaBox.php');
            $objMensaje = new mensajeSistemaBox();

            if ($resultado) {
                $objMensaje->mensajeSistemaBoxShow("Se Agrego con exito", "<a href='../index.php'>Volver al Panel</a>");
            } else {
                $objMensaje->mensajeSistemaBoxShow("ERROR: Ocurrió un problema en la Base de Datos", "<a href='javascript:history.back()'>Intentar de nuevo</a>");
            }
        }
    }
?>
