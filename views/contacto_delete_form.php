<?php require_once '../models/Telefono.php'; ?>
<?php
$tel_modelo = new Telefono();
$telefonos = $tel_modelo->getPorContacto($datos['id']);
$tel_mostrados = !empty($telefonos) ? implode(", ", $telefonos) : "Sin teléfono";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar contacto</title>
    <link rel="stylesheet" href="../views/public/estilos.css">
</head>
<body>
    <h1>Eliminar contacto</h1>
    <p>¿Estás seguro de que deseas eliminar el siguiente contacto?</p>

    <ul>
        <li><strong>ID:</strong> <?= htmlspecialchars($datos['id']) ?></li>
        <li><strong>Nombre:</strong> <?= htmlspecialchars($datos['nombre']) ?></li>
        <li><strong>Apellido:</strong> <?= htmlspecialchars($datos['apellido']) ?></li>
        <li><strong>Teléfonos:</strong> <?= htmlspecialchars($tel_mostrados) ?></li>
        <li><strong>Correo:</strong> <?= htmlspecialchars($datos['correo']) ?></li>
    </ul>

    <form action="contacto_delete.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($datos['id']) ?>">
        <button type="submit">Eliminar</button>
        <a href="contacto_index.php">Cancelar</a>
    </form>
</body>
</html>
