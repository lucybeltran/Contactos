<?php
// Controlador para mostrar la lista de contactos

require_once '../models/Contacto.php'; // Importamos el modelo

$contacto = new Contacto();            // Creamos instancia
$contactos = $contacto->getAllConTelefonos();      // Obtenemos todos los contactos

include '../views/contacto_list.php';  // Mostramos la vista
exit;
