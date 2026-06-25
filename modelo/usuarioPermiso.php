<?php
    include_once('conexion.php');
    class usuarioPermiso extends conexion
    {
        public function obtenerPrivilegios($correo)
        {
            $consulta  = "  SELECT P.nombre as permiso FROM DB_Permiso P
                            INNER JOIN DB_PermisoUsuario PU ON P.db_permiso_id = PU.db_permiso_id
                            INNER JOIN db_usuario U ON PU.db_usuario_id = U.db_usuario_id
                            WHERE U.email = '$correo';";            
            $conexion = $this->conectarBD();
            $respuesta = pg_query($conexion, $consulta);
            $numfilas = pg_num_rows($respuesta);
            $this -> desconectarBD($conexion);
            if($numfilas == 0)
                return NULL;
            else
            {
                for($i = 0; $i < $numfilas; $i++)
                    $vector[$i] = pg_fetch_result($respuesta, $i, 'permiso');
                return $vector;
            }
        }        
    }
?>