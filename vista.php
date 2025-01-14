<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <h1>Bienvenido a la Biblioteca</h1>

    <!-- Formulario para agregar un autor -->
    <form action="index.php" method="POST">
        <label for="nombreAutor">Nombre del Autor:</label>
        <input type="text" id="nombreAutor" name="nombreAutor" required>
        <input type="hidden" name="action" value="agregarAutor">
        <br>
        <button type="submit">Registrar Autor</button>
        
    </form>

    <!-- Formulario para agregar un libro -->
    <form action="index.php" method="POST">
        <br>
        <label for="nombreLibro">Nombre del Libro:</label>
        <input type="text" id="nombreLibro" name="nombreLibro" required>
        <br>
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required>
        <br>
        <label for="disponibilidad">Disponibilidad:</label>
        <input type="text" id="disponibilidad" name="disponibilidad" required>
        <br>
        <input type="hidden" name="action" value="agregarLibro">
        <button type="submit">Registrar Libro</button>
    </form>
</body>
</html>