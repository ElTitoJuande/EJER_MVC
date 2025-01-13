<?php

class db{
    private $conn;

    public function __construct(){
        require_once('../../../cred.php');
        $this->conn = new mysqli("localhost", USU_CONN, PSW_CONN, "biblioteca");
    }
    public function listarLibro(){
        $sentencia = "SELECT * FROM libros";
        $consulta = $this->conn->prepare($sentencia);
        $consulta ->bind_param("s", $id);
        $consulta ->bind_result($id, $nombre, $autor, $disponibilidad);
        $consulta->execute();
        $consulta->fetch();


    }
}

?>