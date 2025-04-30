<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Contactos</title>
    <link rel="stylesheet" href="../views/public/estilos.css">
</head>
<body>
    <div class="contenedor">
    <?php 
    require_once '../models/Telefono.php';
    $tel_modelo = new Telefono();
    ?>


        <h1>Lista de Contactos</h1>

        <!-- Mensaje después de agregar, actualizar o eliminar -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alerta">
                <?php
                    switch ($_GET['mensaje']) {
                        case 'agregado': echo '✅ Contacto agregado correctamente.'; break;
                        case 'actualizado': echo '✏️ Contacto actualizado correctamente.'; break;
                        case 'eliminado': echo '🗑️ Contacto eliminado correctamente.'; break;
                        default: echo '✔️ Acción completada.'; break;
                    }
                ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de búsqueda -->
        <div class="busqueda">
            <form action="contacto_buscar.php" method="GET">
                <input type="text" name="q" placeholder="Buscar por nombre o apellido" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <!-- Botón para registrar nuevo contacto -->
        <a href="contacto_store.php">Registrar nuevo contacto</a>

        <!-- Tabla de contactos -->
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
            
            <?php if (!empty($contactos)): ?>
                <?php foreach ($contactos as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['id']) ?></td>
                        <td><?= htmlspecialchars($c['nombre']) ?></td>
                        <td><?= htmlspecialchars($c['apellido']) ?></td>
                        <?php
                        $telefonos = $tel_modelo->getPorContacto($c['id']);
                        $tel_mostrados = implode(", ", $telefonos);
                        ?>
                        <td><?= htmlspecialchars($tel_mostrados) ?></td>
                        <td><?= htmlspecialchars($c['correo']) ?></td>
                        <td><?= htmlspecialchars($c['categoria_nombre']) ?></td>
                        <td>
                        <a  class="boton-actualizar" href="contacto_update.php?id=<?= $c['id'] ?>">Actualizar</a>
                        <a  class="boton-eliminar" href="contacto_delete.php?id=<?= $c['id'] ?>" >Eliminar</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Contacto no encontrado.</td>
                </tr>
            <?php endif; ?>
        </table>

        <br>
        <a href="../index.php" class="btn-volver">← Volver al inicio</a>
    </div>
</body>
</html>
