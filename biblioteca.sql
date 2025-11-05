-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 05, 2025 at 09:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteca`
--

-- --------------------------------------------------------

--
-- Table structure for table `ejemplar`
--

CREATE TABLE `ejemplar` (
  `id_ejemplar` int(11) NOT NULL,
  `estado` enum('disponible','prestado') DEFAULT 'disponible',
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ejemplar`
--

INSERT INTO `ejemplar` (`id_ejemplar`, `estado`, `id_libro`) VALUES
(1, 'disponible', 1),
(2, 'disponible', 1),
(3, 'disponible', 2),
(4, 'disponible', 2),
(5, 'disponible', 3),
(6, 'disponible', 3),
(7, 'disponible', 4),
(8, 'disponible', 4),
(9, 'disponible', 5),
(10, 'disponible', 5),
(11, 'disponible', 6),
(12, 'disponible', 6),
(13, 'disponible', 7),
(14, 'disponible', 7),
(15, 'disponible', 8),
(16, 'disponible', 8),
(17, 'disponible', 9),
(18, 'disponible', 9),
(19, 'disponible', 10),
(20, 'disponible', 10);

-- --------------------------------------------------------

--
-- Table structure for table `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `isbn` char(13) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `editorial` varchar(50) DEFAULT NULL,
  `autor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `libros`
--

INSERT INTO `libros` (`id`, `isbn`, `titulo`, `editorial`, `autor`) VALUES
(1, '9780000000001', 'El Principito', 'Reynal & Hitchcock', 'Antoine de Saint-Exupéry'),
(2, '9780000000002', 'Cien años de soledad', 'Sudamericana', 'Gabriel García Márquez'),
(3, '9780000000003', 'Don Quijote de la Mancha', 'Francisco de Robles', 'Miguel de Cervantes'),
(4, '9780000000004', '1984', 'Secker & Warburg', 'George Orwell'),
(5, '9780000000005', 'Fahrenheit 451', 'Ballantine Books', 'Ray Bradbury'),
(6, '9780000000006', 'Crimen y castigo', 'The Russian Messenger', 'Fiódor Dostoyevski'),
(7, '9780000000007', 'Orgullo y prejuicio', 'T. Egerton', 'Jane Austen'),
(8, '9780000000008', 'Moby Dick', 'Harper & Brothers', 'Herman Melville'),
(9, '9780000000009', 'La Odisea', 'Penguin Classics', 'Homero'),
(10, '9780000000010', 'Harry Potter y la piedra filosofal', 'Bloomsbury', 'J. K. Rowling');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_usuario` char(8) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `perfil` varchar(50) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_usuario`, `contrasena`, `perfil`) VALUES
('1', '123', 'administrador'),
('10', '123', 'usuario'),
('12', '123', 'usuario'),
('2', '123', 'administrador'),
('3', '123', 'usuario'),
('4', '123', 'usuario'),
('5', '123', 'usuario'),
('6', '123', 'usuario'),
('7', '123', 'usuario'),
('8', '123', 'usuario'),
('9', '123', 'usuario');

-- --------------------------------------------------------

--
-- Table structure for table `prestamo`
--

CREATE TABLE `prestamo` (
  `id_prestamo` int(11) NOT NULL,
  `cedula` char(8) NOT NULL,
  `id_ejemplar` int(11) NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_prevista_devolucion` date DEFAULT NULL,
  `fecha_devolucion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestamo`
--

INSERT INTO `prestamo` (`id_prestamo`, `cedula`, `id_ejemplar`, `fecha_prestamo`, `fecha_prevista_devolucion`, `fecha_devolucion`) VALUES
(1, '1', 1, '2025-11-05', '2025-11-06', '2025-11-05'),
(2, '2', 2, '2025-11-05', '2025-11-07', '2025-11-05'),
(5, '3', 3, '2025-11-03', '2025-11-04', '2025-11-05'),
(6, '3', 3, '2025-11-05', '2025-11-05', '2025-11-05'),
(8, '4', 4, '2025-11-05', '2025-11-06', '2025-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `cedula` char(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`cedula`, `nombre`, `direccion`) VALUES
('1', 'Ana Gómez', 'Calle 1'),
('10', 'Diego Silva', 'Calle 10'),
('12', 'Jose', 'Gomez'),
('2', 'Luis Pérez', 'Calle 2'),
('3', 'María López', 'Calle 3'),
('4', 'Carlos Díaz', 'Calle 4'),
('5', 'Lucía Fernández', 'Calle 5'),
('6', 'Javier Castro', 'Calle 6'),
('7', 'Sofía Morales', 'Calle 7'),
('8', 'Pedro Torres', 'Calle 8'),
('9', 'Valentina Ruiz', 'Calle 9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ejemplar`
--
ALTER TABLE `ejemplar`
  ADD PRIMARY KEY (`id_ejemplar`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indexes for table `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `cedula` (`cedula`),
  ADD KEY `id_ejemplar` (`id_ejemplar`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cedula`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ejemplar`
--
ALTER TABLE `ejemplar`
  MODIFY `id_ejemplar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ejemplar`
--
ALTER TABLE `ejemplar`
  ADD CONSTRAINT `ejemplar_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`cedula`);

--
-- Constraints for table `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `usuario` (`cedula`),
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_ejemplar`) REFERENCES `ejemplar` (`id_ejemplar`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
