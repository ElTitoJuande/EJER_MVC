<?php
require_once('class.db.php');
$db = new db();

if (isset($_GET['id'])) {
    $libro = $db->obtenerLibroPorId($_GET['id']);
    if (!$libro) {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Libro</title>
</head>
<body>
    <h2>Editar Libro</h2>
    <form action="controlador.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
        <div>
            <label for="nombreLibro">Nombre del Libro:</label>
            <input type="text" id="nombreLibro" name="nombreLibro" value="<?php echo htmlspecialchars($libro['nombre']); ?>" required>
        </div>
        <div>
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
        </div>
        <div>
            <label for="disponibilidad">Disponible:</label>
            <input type="checkbox" id="disponibilidad" name="disponibilidad" value="1" <?php echo $libro['disponibilidad'] ? 'checked' : ''; ?>>
        </div>
        <button type="submit" name="action" value="actualizarLibro">Guardar Cambios</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>