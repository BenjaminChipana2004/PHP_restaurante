<?php
    include_once('conexion.php');
    class usuario extends conexion
    {
        public function validarLogin($correo)
        {
            $consulta  = "SELECT email FROM DB_Usuario WHERE email = '$correo'";
            $conexion = $this->conectarBD();
            $respuesta = pg_query($conexion, $consulta);
            if (!$respuesta) {
            die("Error SQL: " . pg_last_error($conexion));
            }
            $numfilas = pg_num_rows($respuesta);
            $this -> desconectarBD($conexion);
            if($numfilas == 1)
                return 1;
            else
                return 0;
        }

        public function validarPassword($correo,$contrasena)
        {
            $consulta  = "SELECT nombre FROM DB_Usuario WHERE email = '$correo' AND password = '$contrasena'";
            $conexion = $this->conectarBD();
            $respuesta = pg_query($conexion, $consulta);
            $numfilas = pg_num_rows($respuesta);
            $this -> desconectarBD($conexion);
            return ($numfilas == 1) ? pg_fetch_result($respuesta, 0, 'nombre') : false;
        }

        public function obtenerIdUsuario($correo)
        {
            $consulta = "SELECT db_usuario_id as id FROM DB_Usuario WHERE email = '$correo'";
            $conexion = $this->conectarBD();
            $respuesta = pg_query($conexion, $consulta);
            $idUsuario = pg_fetch_result($respuesta, 0, 'id');
            $this -> desconectarBD($conexion);
            return $idUsuario;
        }

        // =========================================================================
        // MÉTODOS AÑADIDOS: AGREGAR USUARIO CON SINTAXIS POSTGRESQL (LÍNEAS NUEVAS)
        // =========================================================================
        public function consultaDNI($dni)
        {
            $consulta = "SELECT dni FROM DB_Usuario WHERE dni = '$dni'";
            $conexion = $this->conectarBD();
            $respuesta = pg_query($conexion, $consulta);
            if (!$respuesta) {
                die("Error SQL: " . pg_last_error($conexion));
            }
            $numfilas = pg_num_rows($respuesta);
            $this->desconectarBD($conexion);
            return $numfilas;
        }

        public function crearNuevoUsuario($nombre, $apellido, $dni, $fecha_nacimiento, $correo, $contrasena, $rol)
        {
            $consulta = "INSERT INTO DB_Usuario (nombre, apellido, dni, fecha_nacimiento, email, password, rol) 
                         VALUES ('$nombre', '$apellido', '$dni', '$fecha_nacimiento', '$correo', '$contrasena', '$rol')";
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            return $resultado;
        }
        // =========================================================================
    }
?>
