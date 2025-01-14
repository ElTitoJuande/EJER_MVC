<?php
include_once 'class.db.php';

$db = new db();

// Lógica para registrar un autor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'agregarAutor' && isset($_POST['nombreAutor'])) {
        $nombreAutor = $_POST['nombreAutor'];
        
        // Verificar si el autor ya existe
        if ($db->comprobAutor($nombreAutor)) {
            echo "El autor '$nombreAutor' ya existe en la base de datos.";
        } else {
            if ($db->registrarAutor($nombreAutor)) {
                echo "El autor '$nombreAutor' se ha registrado exitosamente.";
            } else {
                echo "Error al registrar el autor.";
            }
        }
    }

    // Lógica para registrar un libro
    if ($_POST['action'] === 'agregarLibro' && isset($_POST['nombreLibro'], $_POST['autor'], $_POST['disponibilidad'])) {
        $nombreLibro = $_POST['nombreLibro'];
        $autor = $_POST['autor'];
        $disponibilidad = $_POST['disponibilidad'];
        
        // Verificar si el libro ya existe
        if ($db->comprobLibro($nombreLibro)) {
            echo "El libro '$nombreLibro' ya existe en la base de datos.";
        } else {
            if ($db->registrarLibro($nombreLibro, $autor, $disponibilidad)) {
                echo "El libro '$nombreLibro' se ha registrado exitosamente.";
            } else {
                echo "Error al registrar el libro.";
            }
        }
    }
}
include 'vista.php';
?>