<?php
class db {
    private $conn;
    
    public function __construct() {
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
    
    // Obtener todos los libros
    public function obtenerTodosLosLibros() {
        $sentencia = "SELECT l.id, l.nombre, a.nombre as autor, l.disponibilidad 
                     FROM libros l 
                     JOIN autores a ON l.autor = a.id";
        $resultado = $this->conn->query($sentencia);
        
        $libros = [];
        while ($row = $resultado->fetch_assoc()) {
            $libros[] = $row;
        }
        
        return $libros;
    }
    
    // Obtener un libro por ID
    public function obtenerLibroPorId($id) {
        $sentencia = "SELECT l.id, l.nombre, a.nombre as autor, l.disponibilidad 
                     FROM libros l 
                     JOIN autores a ON l.autor = a.id 
                     WHERE l.id = ?";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $consulta->execute();
        
        $resultado = $consulta->get_result();
        $libro = $resultado->fetch_assoc();
        
        $consulta->close();
        return $libro;
    }
    
    // Actualizar un libro
    public function actualizarLibro($id, $nombreLibro, $autor, $disponibilidad) {
        // Primero nos aseguramos que existe el autor o lo creamos
        $idAutor = $this->obtenerOCrearAutor($autor);
        
        $sentencia = "UPDATE libros SET nombre = ?, autor = ?, disponibilidad = ? WHERE id = ?";
        $consulta = $this->conn->prepare($sentencia);
        $disponibilidadValue = $disponibilidad ? '1' : '0';
        $consulta->bind_param("sisi", $nombreLibro, $idAutor, $disponibilidadValue, $id);
        
        $consulta->execute();
        $res = $consulta->affected_rows >= 0;
        $consulta->close();
        
        return $res;
    }
    
    // Eliminar un libro
    public function eliminarLibro($id) {
        $sentencia = "DELETE FROM libros WHERE id = ?";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("i", $id);
        
        $consulta->execute();
        $res = $consulta->affected_rows == 1;
        $consulta->close();
        
        return $res;
    }
    
    // Función auxiliar para obtener ID de autor o crearlo si no existe
    private function obtenerOCrearAutor($nombreAutor) {
        // Primero intentamos obtener el ID del autor
        $sentencia = "SELECT id FROM autores WHERE nombre = ?";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("s", $nombreAutor);
        $consulta->execute();
        $resultado = $consulta->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            $consulta->close();
            return $fila['id'];
        }
        
        // Si no existe, lo creamos
        $consulta->close();
        $sentencia = "INSERT INTO autores (nombre) VALUES (?)";
        $consulta = $this->conn->prepare($sentencia);
        $consulta->bind_param("s", $nombreAutor);
        $consulta->execute();
        
        $idAutor = $this->conn->insert_id;
        $consulta->close();
        
        return $idAutor;
    }
    
    // Mantener los métodos existentes (comprobAutor, comprobLibro, registrarAutor, registrarLibro, obtenerLibrosPorAutor)
    // ... [resto de métodos que ya tenías]
}
?>