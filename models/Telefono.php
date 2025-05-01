<?php
require_once "Conexion.php";

class Telefono extends Conexion {
    
    // Obtener todos los teléfonos de un contacto
    public function getPorContacto($contacto_id) {
        $this->conectar();
        $stmt = $this->link->prepare("SELECT numero FROM telefonos WHERE contacto_id = ?");
        $stmt->bind_param("i", $contacto_id);
        $stmt->execute();
        $res = $stmt->get_result();

        $telefonos = [];
        while ($fila = $res->fetch_assoc()) {
            $telefonos[] = $fila['numero'];
        }

        return $telefonos;
    }

    // Insertar un nuevo número
    public function insertar($numero, $contacto_id) {
        $this->conectar();
        $stmt = $this->link->prepare("INSERT INTO telefonos (numero, contacto_id) VALUES (?, ?)");
        $stmt->bind_param("si", $numero, $contacto_id);
        $stmt->execute();
        $stmt->close();
    }
    
    // Eliminar todos los teléfonos de un contacto
    public function eliminarPorContacto($contacto_id) {
        $this->conectar();
        $stmt = $this->link->prepare("DELETE FROM telefonos WHERE contacto_id = ?");
        $stmt->bind_param("i", $contacto_id);
        $stmt->execute();
        $stmt->close();
    }

    // (Opcional) Actualizar todos los teléfonos de un contacto (borrando los anteriores)
    public function actualizarTelefonos($contacto_id, $numeros_array) {
        $this->eliminarPorContacto($contacto_id); // Elimina los anteriores
    
        foreach ($numeros_array as $numero) {
            $numero = trim($numero);
            if (!empty($numero)) {
                $this->insertar($numero, $contacto_id);
            }
        }
    }

    // Verifica si un número ya está registrado
    public function existeTelefono($numero) {
        $this->conectar();
        $stmt = $this->link->prepare("SELECT id FROM telefonos WHERE numero = ?");
        $stmt->bind_param("s", $numero);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0;
    }
}
