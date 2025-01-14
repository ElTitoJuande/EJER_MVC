<!DOCTYPE html>
<html>
<head>
    <title>Registro de Libros</title>
</head>
<body>
    <h2>Registrar Nuevo Libro</h2>
    <form action="controlador.php" method="POST">
        <div>
            <label for="nombreLibro">Nombre del Libro:</label>
            <input type="text" id="nombreLibro" name="nombreLibro" required>
        </div>
        <div>
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>
        </div>
        <div>
            <label for="disponibilidad">Disponible:</label>
            <input type="checkbox" id="disponibilidad" name="disponibilidad" value="1">
        </div>
        <button type="submit" name="action" value="registrarLibro">Registrar Libro</button>
        <a href="index.php">Volver</a>
    </form>
</body>
</html>