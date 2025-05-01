<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar contacto</title>
    <link rel="stylesheet" href="../views/public/estilos.css">
</head>
<body>
    <h1>Registrar nuevo contacto</h1>
    <form action="contacto_store.php" method="POST" class="formulario">
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" name="apellido" required><br><br>

        <label for="telefono[]">Teléfono:</label><br>
        <input type="text" name="telefono[]" required><br><br>

        <label for="correo">Correo:</label><br>
        <input type="email" name="correo"><br><br>

        <label for="categoria">Categoría:</label><br>
        <select name="categoria_id" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>">
                    <?= htmlspecialchars($cat['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Guardar</button>
    </form>

    <a href="contacto_index.php" class="btn-volver">← Volver a la lista</a>
</body>
</html>
