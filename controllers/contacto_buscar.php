<?php
require_once '../models/Contacto.php';

$contacto = new Contacto();

if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $termino = trim($_GET['q']);
    $contactos = $contacto->buscar($termino);
} else {
    //  si el campo de busqueda esta vacío, muestra todos los contactos
    $contactos = $contacto->getAllConTelefonos(); // usa el metodo que ya muestra todo
}

include '../views/contacto_list.php';
exit;
