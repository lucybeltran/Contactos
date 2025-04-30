<?php
require_once "Conexion.php";

class Categoria extends Conexion {
    public function getAll() {
        $this->conectar();
        $stmt = $this->link->prepare("SELECT * FROM categorias");
        $stmt->execute();
        $res = $stmt->get_result();

        $categorias = [];
        while ($fila = $res->fetch_assoc()) {
            $categorias[] = $fila;
        }

        return $categorias;
    }
}
