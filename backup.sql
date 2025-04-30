CREATE DATABASE IF NOT EXISTS contactos;
USE contactos;

-- Tabla de categorías
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT
);

-- Tabla de contactos
CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Tabla de teléfonos
CREATE TABLE telefonos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(20) NOT NULL,
    contacto_id INT,
    FOREIGN KEY (contacto_id) REFERENCES contactos(id)
        ON DELETE CASCADE
);

-- Categorías de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES
('Amigos', 'Personas cercanas y de confianza.'),
('Trabajo', 'Contactos laborales y clientes.'),
('Familia', 'Personas muy cercanas.');

-- Contactos de ejemplo
INSERT INTO contactos (nombre, apellido, correo, categoria_id) VALUES
('Ana', 'Gonzalez', 'ana.gonzalez@gmail.com', 1),
('Luis', 'Perez', 'luis.perez@empresa.com', 2),
('María', 'Lozano', 'maria.lozano@hotmail.com', 1);

-- Teléfonos relacionados
INSERT INTO telefonos (numero, contacto_id) VALUES
('71234567', 1),
('75444332', 1),
('72345678', 2),
('73456789', 3);
