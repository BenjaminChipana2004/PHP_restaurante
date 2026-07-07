<?php
    class controllerAgregarUsuario
    {
        public function agregarUsuario($login, $password)
        {
            include_once('../modelo/usuario.php');
            $objUsuario = new usuario();
            
            // Reutilizamos tu método existente para verificar duplicidad
            $existe = $objUsuario->validarLogin($login);
            
            if ($existe == 1) {
                include_once('../shared/mensajeSistemaBox.php');
                $objMensaje = new mensajeSistemaBox();
                $objMensaje->mensajeSistemaBoxShow("ERROR: El nombre de usuario '$login' ya se encuentra registrado", "<a href='javascript:history.back()'>Elegir otro nombre</a>");
            } else {
                // Ejecutamos el método que añadimos al modelo
                $resultado = $objUsuario->registrarUsuario($login, $password);
                
                if ($resultado) {
                    include_once('../shared/mensajeSistemaBox.php');
                    $objMensaje = new mensajeSistemaBox();
                    $objMensaje->mensajeSistemaBoxShow("ÉXITO: El usuario ha sido agregado correctamente", "<a href='../index.php'>Volver al Inicio</a>");
                } else {
                    include_once('../shared/mensajeSistemaBox.php');
                    $objMensaje = new mensajeSistemaBox();
                    $objMensaje->mensajeSistemaBoxShow("ERROR: No se pudo registrar en la Base de Datos", "<a href='javascript:history.back()'>Intentar más tarde</a>");
                }
            }
        }
    }
?>