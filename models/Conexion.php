<?php
class Conexion {
    protected $link;
    private $host = 'localhost';
    private $usuario = 'root';
    private $contrasena = '';
    private $base_datos = 'contactos';
    private $port = 3308;

    public function conectar() {
        try {
            $this->link = new mysqli(
                $this->host,
                $this->usuario,
                $this->contrasena,
                $this->base_datos,
                $this->port
            );
        } catch (Exception $error) {
            echo "Error al conectar: " . $error->getMessage();
            exit;
        }
    }
}
