-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-08-2025 a las 11:05:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bior`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bior`
--

CREATE TABLE `bior` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `folio` int(11) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `locacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bior`
--

INSERT INTO `bior` (`id`, `fecha`, `cantidad`, `folio`, `cliente`, `precio`, `locacion`) VALUES
(1, '2025-08-13', 15.00, 3222, 'Juan', 12311.12, 'Avenida Belona 4226, Victoria Residencial, Mexicali, 21395');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `folio` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(20,2) NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `rutas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `folio`, `nombre`, `precio`, `ubicacion`, `rutas`) VALUES
(11, '123131', 'Juan', 12311.12, NULL, '2'),
(12, '322313', 'Hot dogs', 2323.23, NULL, '2'),
(13, '213123', 'Michoacana 2', 23223.23, NULL, '1'),
(14, '3222', 'Juan', 2323.23, NULL, '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas_completadas`
--

CREATE TABLE `rutas_completadas` (
  `id_ruta_completada` int(11) NOT NULL,
  `folio` varchar(255) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `precio` decimal(20,2) NOT NULL,
  `cantidad` decimal(20,2) NOT NULL,
  `fecha` date NOT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `rutas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rutas_completadas`
--

INSERT INTO `rutas_completadas` (`id_ruta_completada`, `folio`, `cliente`, `precio`, `cantidad`, `fecha`, `ubicacion`, `rutas`) VALUES
(1, '432342', 'Juan', 2330.23, 2332.00, '2024-02-09', NULL, '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bior`
--
ALTER TABLE `bior`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `rutas_completadas`
--
ALTER TABLE `rutas_completadas`
  ADD PRIMARY KEY (`id_ruta_completada`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bior`
--
ALTER TABLE `bior`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `rutas_completadas`
--
ALTER TABLE `rutas_completadas`
  MODIFY `id_ruta_completada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
