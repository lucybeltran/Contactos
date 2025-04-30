<?php
/*
    Controlador de actualización de contacto
    Si el método es POST, se actualiza un contacto
    Si el método es GET, se muestra el formulario con los datos actuales
*/

require_once '../models/Contacto.php';
require_once '../models/Categoria.php';
require_once '../models/Telefono.php'; 

$contacto = new Contacto();
$categoria = new Categoria();
$telefono = new Telefono();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //  Validar correo antes de actualizar
    if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        echo "Correo no válido.";
        exit;
    }

    // Asignar los valores al contacto
    $contacto->id = $_POST['id'];
    $contacto->nombre = $_POST['nombre'];
    $contacto->apellido = $_POST['apellido'];
    $contacto->correo = $_POST['correo'];    
    $contacto->categoria_id = $_POST['categoria_id'];

    // Actualizar en la base de datos
    $contacto->update($contacto->id);

    // Actualizar los teléfonos si hay
    if (isset($_POST['telefono']) && is_array($_POST['telefono'])) {
        $telefono->actualizarTelefonos($contacto->id, $_POST['telefono']);
    }

    // Redirigir con mensaje de éxito
    header('Location: contacto_index.php?mensaje=actualizado');
    exit;

} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mostrar el formulario con los datos del contacto
    $datos = $contacto->getFirst($_GET['id']);
    $categorias = $categoria->getAll();

    if (!$datos) {
        echo "Contacto con ID {$_GET['id']} no encontrado.";
        exit;
    } else {
        include '../views/contacto_update_form.php';
        exit;
    }
}
