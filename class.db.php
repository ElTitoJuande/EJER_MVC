<?php
class db {
    private $conn;

    public function __construct() {
        // Incluye las credenciales para la conexión
        require_once('../../../cred.php'); 
        $this->conn = new mysqli("localhost", USU_CONN, PSW_CONN, "biblioteca");

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Comprobar si un autor existe
    public function comprobAutor(String $nombreAutor) {
        $sentencia = "SELECT COUNT(*) FROM autores WHERE nombre = ?";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("s", $nombreAutor);
        $consulta->bind_result($count);

        $consulta->execute();
        $consulta->fetch();

        $existe = false;
        if ($count == 1) $existe = true;

        $consulta->close();

        return $existe;
    }

    // Comprobar si un libro existe
    public function comprobLibro(String $nombreLibro) {
        $sentencia = "SELECT COUNT(*) FROM libros WHERE nombre = ?";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("s", $nombreLibro); 
        $consulta->bind_result($count);

        $consulta->execute();
        $consulta->fetch();

        $existe = false;
        if ($count == 1) $existe = true;

        $consulta->close();

        return $existe;
    }

    // Registrar un nuevo autor
    public function registrarAutor(String $nombreAutor) {
        $sentencia = "INSERT INTO autores (nombre) VALUES (?)";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("s", $nombreAutor); 

        $consulta->execute();
        
        $res = false;
        if ($consulta->affected_rows == 1) $res = true;

        $consulta->close();

        return $res;
    }

    // Registrar un nuevo libro
    public function registrarLibro(String $nombreLibro, String $autor, bool $disponibilidad) {
        $disponibilidadValue = $disponibilidad ? '1' : '0';
        $sentencia = "INSERT INTO libros (nombre, autor, disponibilidad) VALUES (?, ?, ?)";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("sss", $nombreLibro, $autor, $disponibilidadValue);
        
        $consulta->execute();
        
        $res = false;
        if ($consulta->affected_rows == 1) $res = true;
    
        $consulta->close();
    
        return $res;
    }

    // Obtener los libros de un autor específico
    public function obtenerLibrosPorAutor(String $nombreAutor) {
        // Primero obtener el ID del autor
        $sentenciaAutor = "SELECT id FROM autores WHERE nombre = ?";
        $consultaAutor = $this->conn->prepare($sentenciaAutor);
        $consultaAutor->bind_param("s", $nombreAutor);
        $consultaAutor->execute();
        $consultaAutor->bind_result($idAutor);
        $consultaAutor->fetch();
        $consultaAutor->close();
    
        // Luego, obtener los libros de ese autor
        $sentenciaLibros = "SELECT nombre, disponibilidad FROM libros WHERE autor = ?";
        $consultaLibros = $this->conn->prepare($sentenciaLibros);
        $consultaLibros->bind_param("i", $idAutor); // Pasamos el id del autor
        $consultaLibros->execute();
    
        $result = $consultaLibros->get_result();
        $libros = [];
        while ($row = $result->fetch_assoc()) {
            $libros[] = $row;
        }
    
        $consultaLibros->close();
    
        return $libros;
    }
    
}
?>
