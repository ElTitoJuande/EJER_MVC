<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Biblioteca</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .actions { display: flex; gap: 10px; }
    </style>
</head>
<body>
<h1>Biblioteca</h1>
    <div style="margin-bottom: 20px;">
        <a href="formulario.php">Agregar Nuevo Libro</a> | 
        <a href="formulario_autor.php">Agregar Nuevo Autor</a>
    </div>
    <h2>Lista de Libros</h2>
    <table>
        <thead>
            <tr>
                <th>Libro</th>
                <th>Autor</th>
                <th>Disponibilidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('class.db.php');
            $db = new db();
            $libros = $db->obtenerTodosLosLibros();
            
            foreach($libros as $libro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($libro['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                    <td><?php echo $libro['disponibilidad'] ? 'Disponible' : 'No disponible'; ?></td>
                    <td class="actions">
                        <a href="editar.php?id=<?php echo $libro['id']; ?>">Editar</a>
                        <form action="controlador.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                            <input type="hidden" name="action" value="eliminarLibro">
                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este libro?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>