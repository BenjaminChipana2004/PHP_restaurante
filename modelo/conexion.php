<?php
class Conexion
{
    private $host = "localhost";
    private $port = "5432";
    private $dbname = "restaurante";
    private $user = "postgres"; // <-- REEMPLAZA "postgres" POR TU USUARIO REAL DE PGADMIN SI ES DISTINTO
    private $password = "admin"; // <-- REEMPLAZA "postgres" POR TU CONTRASEÑA REAL DE PGADMIN SI ES DISTINTA

    protected function conectarBD()
    {
        $cadenaConexion = "
            host=$this->host
            port=$this->port
            dbname=$this->dbname
            user=$this->user
            password=$this->password
        ";

        $conexion = pg_connect($cadenaConexion);

        if (!$conexion) {
            die("Error: No se pudo conectar a la base de datos.");
        }

        return $conexion;
    }

    protected function desconectarBD($conexion)
    {
        if ($conexion) {
            pg_close($conexion);
        }
    }
}