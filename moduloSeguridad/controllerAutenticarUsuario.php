<?php
    class controllerAutenticarUsuario
    {
        public function validarUsuario($correo,$contrasena)
        {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            include_once('../modelo/usuario.php');
            $objUsuario = new usuario();
            $resultado = $objUsuario -> validarLogin($correo);
            if(!$resultado)
            {
                include_once('../shared/mensajeSistemaBox.php');
                $objMensaje = new mensajeSistemaBox();
                $objMensaje -> mensajeSistemaBoxShow("ERROR: Usuario no encontrado","<a href='../index.php'>ingresar correctamente</a>");    
            }
            else
            {
                $nombreUsuario = $objUsuario -> validarPassword($correo,$contrasena);
                if(!$nombreUsuario)
                {
                    include_once('../shared/mensajeSistemaBox.php');
                    $objMensaje = new mensajeSistemaBox();
                    $objMensaje -> mensajeSistemaBoxShow("ERROR: la contrasena es incorrecta","<a href='../index.php'>ingresar correctamente</a>");    
                }
                else
                {
                    include_once('../modelo/usuarioPermiso.php');
                    $objUsuarioPriv = new usuarioPermiso();
                    $listaPrivilegios = $objUsuarioPriv -> obtenerPrivilegios($correo);
                    if($listaPrivilegios == NULL)
                    {
                        include_once('../shared/mensajeSistemaBox.php');
                        $objMensaje = new mensajeSistemaBox();
                        $objMensaje -> mensajeSistemaBoxShow("ERROR: El usuario esta deshabilitado","<a href='../index.php'>ingresar correctamente</a>");    
                    }
                    else
                    {
                        $idUsuario = $objUsuario -> obtenerIdUsuario($correo);
                        $_SESSION['idUsuario'] = $idUsuario;
                        $_SESSION['nombre'] = $nombreUsuario;
                        $_SESSION['listaPrivilegios'] = $listaPrivilegios;
                        include_once("../shared/formPanelControl.php");
                        $objScreen = new formPanelControl();
                        $objScreen -> formPanelControlShow($listaPrivilegios);
                    }
                }
            }
        }
    }

?>