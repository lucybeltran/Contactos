<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar contacto</title>
    <link rel="stylesheet" href="../views/public/estilos.css">
</head>
<body>
    <h1>Actualizar contacto</h1>

    <form action="contacto_update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($datos['id']) ?>">

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required><br><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" name="apellido" value="<?= htmlspecialchars($datos['apellido']) ?>" required><br><br>

        <!-- TELEFONOS MULTIPLES DE UN CONTACTO -->
        <?php
        require_once '../models/Telefono.php';
        $tel_modelo = new Telefono();
        $telefonos = $tel_modelo->getPorContacto($datos['id']);
        ?>

        <label for="telefono[]">Teléfonos:</label><br>
        <?php foreach ($telefonos as $numero): ?>
            <input type="text" name="telefono[]" value="<?= htmlspecialchars($numero) ?>"><br>
        <?php endforeach; ?>
        <!-- Campo adicional vacío para nuevo numero -->
        <input type="text" name="telefono[]" placeholder="Nuevo número (opcional)"><br><br>

        <label for="correo">Correo:</label><br>
        <input type="email" name="correo" value="<?= htmlspecialchars($datos['correo']) ?>"><br><br>

        <label for="categoria">Categoría:</label><br>
        <select name="categoria_id" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $datos['categoria_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Actualizar</button>
    </form>
 
    <a href="contacto_index.php" class="btn-volver">← Volver a la lista</a>
</body>
</html>
