<?php
/*
    Controlador de registro de contacto
    Si el método es GET, se muestra el formulario de registro
    Si el método es POST, se guarda un nuevo contacto
*/

require_once '../models/Contacto.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crear nuevo contacto
    $contacto = new Contacto();
    $contacto->nombre = $_POST['nombre'];
    $contacto->apellido = $_POST['apellido'];
    $contacto->telefono = $_POST['telefono'];
    $contacto->correo = $_POST['correo'];
    $contacto->categoria_id = $_POST['categoria_id'];
    $contacto->create();

    // Redirigir a la lista de contactos
    header('Location: contacto_index.php?mensaje=agregado');
    exit;

} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mostrar formulario de registro
    // Necesitamos cargar las categorías para el <select>
    require_once '../models/categoria.php';
    $cat = new Categoria();
    $categorias = $cat->getAll();

    include '../views/contacto_create_form.php';
    exit;
}


