<?php
/*
    Controlador de eliminación de contacto
    Si el método es POST, se elimina un contacto
    Si el método es GET, se muestra una vista de confirmación
*/

require_once '../models/Contacto.php';

$contacto = new Contacto();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Eliminar el contacto
    $contacto->delete($_POST['id']);
    header('Location: contacto_index.php?mensaje=eliminado');
    exit;

} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mostrar el formulario de confirmación
    $datos = $contacto->getFirst($_GET['id']);

    if (!$datos) {
        echo "Contacto con ID {$_GET['id']} no encontrado.";
        exit;
    } else {
        include '../views/contacto_delete_form.php';
        exit;
    }
}


