<?php
/*
    Controlador de registro de contacto
    Si el método es GET, se muestra el formulario de registro
    Si el método es POST, se guarda un nuevo contacto
*/

require_once '../models/Contacto.php';
require_once '../models/Telefono.php';
require_once '../models/Categoria.php';

$contacto = new Contacto();
$telefono = new Telefono();
$categoria = new Categoria();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ✅ Validar campos obligatorios
    if (empty(trim($_POST['nombre'])) || empty(trim($_POST['apellido']))) {
        echo "Nombre y apellido son obligatorios.";
        exit;
    }

    // ✅ Validar correo
    if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        echo "Correo no válido.";
        exit;
    }

    // ✅ Validar categoría
    if (empty($_POST['categoria_id']) || !is_numeric($_POST['categoria_id'])) {
        echo "Debe seleccionar una categoría válida.";
        exit;
    }

    // ✅ Validar teléfonos
    // Validar teléfonos
if (!isset($_POST['telefono']) || !is_array($_POST['telefono'])) {
    echo "Debe ingresar al menos un número de teléfono.";
    exit;
}

$telefonos_limpios = array_unique(array_map('trim', $_POST['telefono']));
$hay_valido = false;

foreach ($telefonos_limpios as $num) {
    if (!empty($num)) {
        if (!preg_match('/^[0-9]{8,}$/', $num)) {
            echo "El número de teléfono '$num' no es válido (mínimo 8 dígitos).";
            exit;
        }
        if ($telefono->existeTelefono($num)) {
            echo "El número de teléfono '$num' ya está registrado en otro contacto.";
            exit;
        }
        $hay_valido = true;
    }
}

if (!$hay_valido) {
    echo "Debe ingresar al menos un número de teléfono válido.";
    exit;
}


    //  Crear el contacto
    $contacto->nombre = $_POST['nombre'];
    $contacto->apellido = $_POST['apellido'];
    $contacto->correo = $_POST['correo'];
    $contacto->categoria_id = $_POST['categoria_id'];
    $contacto->create();

    //  Obtener el ID generado (agregado)
    $contacto_id = $contacto->getInsertId();


    //  Insertar teléfonos
    foreach ($telefonos_limpios as $num) {
        if (!empty($num)) {
            $telefono->insertar($num, $contacto_id);
        }
    }

    // Redirigir al listado
    header('Location: contacto_index.php?mensaje=agregado');
    exit;

} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mostrar formulario de registro
    $categorias = $categoria->getAll();
    include '../views/contacto_create_form.php';
    exit;
}
