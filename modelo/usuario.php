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
        // MÉTODOS MODIFICADOS: ALINEADOS A LAS COLUMNAS REALES DE TU BD
        // =========================================================================
        public function consultaDNI($dni)
        {
            // Tu tabla usa 'codUsuario' para almacenar el identificador numérico/DNI
            $consulta = "SELECT codUsuario FROM DB_Usuario WHERE codUsuario = '$dni'";
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
            // Fusionamos nombre y apellido en la columna única 'nombre' de tu BD
            $nombreCompleto = $nombre . " " . $apellido;
            
            // Pasamos los datos respetando tus columnas: codUsuario y DB_Rol_ID
            $consulta = "INSERT INTO DB_Usuario (codUsuario, nombre, email, password, activo, DB_Rol_ID) 
                         VALUES ('$dni', '$nombreCompleto', '$correo', '$contrasena', TRUE, '$rol')";
            
            $conexion = $this->conectarBD();
            $resultado = pg_query($conexion, $consulta);
            $this->desconectarBD($conexion);
            return $resultado;
        }
        // =========================================================================
    }
?>