<!DOCTYPE html>
<html>
<head>
    <title>Registro de Autores</title>
</head>
<body>
    <h2>Registrar Nuevo Autor</h2>
    <form action="controlador.php" method="POST">
        <div>
            <label for="nombreAutor">Nombre del Autor:</label>
            <input type="text" id="nombreAutor" name="nombreAutor" required>
        </div>
        <button type="submit" name="action" value="registrarAutor">Registrar Autor</button>
        <a href="index.php">Volver</a>
    </form>
</body>
</html>