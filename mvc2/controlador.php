<?php
require_once('class.db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $db = new db();
    
    switch($_POST['action']) {
        case 'registrarLibro':
            $nombreLibro = $_POST['nombreLibro'];
            $autor = $_POST['autor'];
            $disponibilidad = isset($_POST['disponibilidad']);
            
            if (!$db->comprobLibro($nombreLibro)) {
                if ($db->registrarLibro($nombreLibro, $autor, $disponibilidad)) {
                    header('Location: index.php?mensaje=Libro registrado correctamente');
                } else {
                    header('Location: index.php?error=Error al registrar el libro');
                }
            } else {
                header('Location: index.php?error=El libro ya existe');
            }
            break;
            
        case 'actualizarLibro':
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $nombreLibro = $_POST['nombreLibro'];
                $autor = $_POST['autor'];
                $disponibilidad = isset($_POST['disponibilidad']);
                
                if ($db->actualizarLibro($id, $nombreLibro, $autor, $disponibilidad)) {
                    header('Location: index.php?mensaje=Libro actualizado correctamente');
                } else {
                    header('Location: index.php?error=Error al actualizar el libro');
                }
            }
            break;
            
        case 'eliminarLibro':
            if (isset($_POST['id'])) {
                if ($db->eliminarLibro($_POST['id'])) {
                    header('Location: index.php?mensaje=Libro eliminado correctamente');
                } else {
                    header('Location: index.php?error=Error al eliminar el libro');
                }
            }
            break;
            case 'registrarAutor':
                $nombreAutor = $_POST['nombreAutor'];
                
                if (!$db->comprobAutor($nombreAutor)) {
                    if ($db->registrarAutor($nombreAutor)) {
                        header('Location: index.php?mensaje=Autor registrado correctamente');
                    } else {
                        header('Location: index.php?error=Error al registrar el autor');
                    }
                } else {
                    header('Location: index.php?error=El autor ya existe');
                }
                break;
    }
}

exit;
?>