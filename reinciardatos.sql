DROP DATABASE IF EXISTS biblioteca;
CREATE DATABASE biblioteca CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE biblioteca;

CREATE TABLE usuario (
  cedula CHAR(8) NOT NULL,
  nombre VARCHAR(50) NOT NULL,
  direccion VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (cedula)
);

CREATE TABLE libros (
  id INT(11) NOT NULL AUTO_INCREMENT,
  isbn CHAR(13) NOT NULL,
  titulo VARCHAR(100) NOT NULL,
  editorial VARCHAR(50) DEFAULT NULL,
  autor VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (isbn)
);

CREATE TABLE ejemplar (
  id_ejemplar INT(11) NOT NULL AUTO_INCREMENT,
  estado ENUM('disponible','prestado') DEFAULT 'disponible',
  id_libro INT(11) NOT NULL,
  PRIMARY KEY (id_ejemplar),
  KEY (id_libro),
  CONSTRAINT ejemplar_ibfk_1 FOREIGN KEY (id_libro) REFERENCES libros (id)
);

CREATE TABLE prestamo (
  id_prestamo INT(11) NOT NULL AUTO_INCREMENT,
  cedula CHAR(8) NOT NULL,
  id_ejemplar INT(11) NOT NULL,
  fecha_prestamo DATE NOT NULL,
  fecha_prevista_devolucion DATE DEFAULT NULL,
  fecha_devolucion DATE DEFAULT NULL,
  PRIMARY KEY (id_prestamo),
  KEY (cedula),
  KEY (id_ejemplar),
  CONSTRAINT prestamo_ibfk_1 FOREIGN KEY (cedula) REFERENCES usuario (cedula),
  CONSTRAINT prestamo_ibfk_2 FOREIGN KEY (id_ejemplar) REFERENCES ejemplar (id_ejemplar)
);

-- Insertar usuarios
INSERT INTO usuario (cedula, nombre, direccion) VALUES
('1', 'Ana Gómez', 'Calle 1'),
('2', 'Luis Pérez', 'Calle 2'),
('3', 'María López', 'Calle 3'),
('4', 'Carlos Díaz', 'Calle 4'),
('5', 'Lucía Fernández', 'Calle 5'),
('6', 'Javier Castro', 'Calle 6'),
('7', 'Sofía Morales', 'Calle 7'),
('8', 'Pedro Torres', 'Calle 8'),
('9', 'Valentina Ruiz', 'Calle 9'),
('10', 'Diego Silva', 'Calle 10');

-- Insertar libros
INSERT INTO libros (isbn, titulo, editorial, autor) VALUES
('9780000000001', 'El Principito', 'Reynal & Hitchcock', 'Antoine de Saint-Exupéry'),
('9780000000002', 'Cien años de soledad', 'Sudamericana', 'Gabriel García Márquez'),
('9780000000003', 'Don Quijote de la Mancha', 'Francisco de Robles', 'Miguel de Cervantes'),
('9780000000004', '1984', 'Secker & Warburg', 'George Orwell'),
('9780000000005', 'Fahrenheit 451', 'Ballantine Books', 'Ray Bradbury'),
('9780000000006', 'Crimen y castigo', 'The Russian Messenger', 'Fiódor Dostoyevski'),
('9780000000007', 'Orgullo y prejuicio', 'T. Egerton', 'Jane Austen'),
('9780000000008', 'Moby Dick', 'Harper & Brothers', 'Herman Melville'),
('9780000000009', 'La Odisea', 'Penguin Classics', 'Homero'),
('9780000000010', 'Harry Potter y la piedra filosofal', 'Bloomsbury', 'J. K. Rowling');

-- Insertar ejemplares (2 por libro)
INSERT INTO ejemplar (estado, id_libro) VALUES
('disponible', 1), ('disponible', 1),
('disponible', 2), ('disponible', 2),
('disponible', 3), ('disponible', 3),
('disponible', 4), ('disponible', 4),
('disponible', 5), ('disponible', 5),
('disponible', 6), ('disponible', 6),
('disponible', 7), ('disponible', 7),
('disponible', 8), ('disponible', 8),
('disponible', 9), ('disponible', 9),
('disponible', 10), ('disponible', 10);
