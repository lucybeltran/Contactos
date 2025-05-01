<?php
require_once "Conexion.php";
require_once 'Telefono.php';

// Clase Contacto que hereda de la clase Conexion
class Contacto extends Conexion {
    // Atributos del contacto (campos de la tabla)
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $correo;
    public $categoria_id;

    // Metodo para registrar  un nuevo contacto
    public function create() {
        $this->conectar(); // Conectamos a la base de datos
        // Preparamos la consulta SQL con valores por parámetros
        $stmt = $this->link->prepare("INSERT INTO contactos (nombre, apellido, correo, categoria_id) VALUES (?, ?, ?, ?)");
        // Asignamos los valores a la consulta
        $stmt->bind_param("sssi", $this->nombre, $this->apellido, $this->correo, $this->categoria_id);
        $stmt->execute(); // Ejecutamos
        $stmt->close();   // Cerramos la consulta
    }

    // Método para obtener todos los contactos con su categoría
    public function getAll() {
        $this->conectar(); // Conectamos a la base de datos
        // LEFT JOIN para traer también el nombre de la categoría
        $stmt = $this->link->prepare(
            "SELECT contactos.*, categorias.nombre AS categoria_nombre 
             FROM contactos 
             LEFT JOIN categorias ON contactos.categoria_id = categorias.id 
             ORDER BY contactos.id ASC"
        );
        $stmt->execute(); // Ejecutamos
        $res = $stmt->get_result(); // Obtenemos el resultado

        // Guardamos los resultados en un array
        $contactos = [];
        while ($fila = $res->fetch_assoc()) {
            $contactos[] = $fila;
        }

        return $contactos; // Devolvemos todos los contactos
    } 

    // Método para obtener un solo contacto por su ID
    public function getFirst($id) {
        $this->conectar(); // Conectamos
        $stmt = $this->link->prepare("SELECT * FROM contactos WHERE id = ?");
        $stmt->bind_param("i", $id); // Asignamos el ID
        $stmt->execute(); // Ejecutamos
        $res = $stmt->get_result(); // Resultado
        return $res->fetch_assoc(); // Devolvemos solo un registro
    }

    // Método para actualizar un contacto existente
    public function update($id) {
        $this->conectar();
        $stmt = $this->link->prepare(
            "UPDATE contactos SET nombre = ?, apellido = ?, correo = ?, categoria_id = ? WHERE id = ?"
        );
        // 3 strings y 2 enteros
        $stmt->bind_param("sssii", $this->nombre, $this->apellido, $this->correo, $this->categoria_id, $id);
        $stmt->execute();
        $stmt->close();
    }
    
    // Método para eliminar un contacto
    public function delete($id) {
        $this->conectar(); // Conectamos
        $stmt = $this->link->prepare("DELETE FROM contactos WHERE id = ?");
        $stmt->bind_param("i", $id); // Asignamos el ID
        $stmt->execute(); // Ejecutamos
        $stmt->close();   // Cerramos
    }

    // Método para buscar contactos por nombre o apellido
    public function buscar($termino) {
        $this->conectar();
        $buscar = "%$termino%";
    
        $stmt = $this->link->prepare(
            "SELECT contactos.*, categorias.nombre AS categoria_nombre
             FROM contactos
             LEFT JOIN categorias ON contactos.categoria_id = categorias.id
             WHERE contactos.nombre LIKE ? OR contactos.apellido LIKE ?"
        );
    
        $stmt->bind_param("ss", $buscar, $buscar);
        $stmt->execute();
        $res = $stmt->get_result();
    
        $resultados = [];
        while ($fila = $res->fetch_assoc()) {
            $resultados[] = $fila;
        }
    
        return $resultados;
    }

    // Obtener todos los contactos con sus teléfonos
    public function getAllConTelefonos() {
        $this->conectar();

        // Trae todos los contactos con la categoría
        $stmt = $this->link->prepare(
            "SELECT c.*, cat.nombre AS categoria_nombre
             FROM contactos c
             LEFT JOIN categorias cat ON c.categoria_id = cat.id"
        );
        $stmt->execute();
        $res = $stmt->get_result();

        $contactos = [];
        while ($fila = $res->fetch_assoc()) {
            // Obtener los teléfonos para este contacto
            $id = $fila['id'];
            $telefonoModelo = new Telefono();
            $telefonos = $telefonoModelo->getPorContacto($id);

            // Agregamos los teléfonos al contacto
            $fila['telefonos'] = $telefonos;

            $contactos[] = $fila;
        }

        return $contactos;
    }

    //  Obtener el ID insertado después de crear
    public function getInsertId() {
        return $this->link->insert_id;
    }
}
