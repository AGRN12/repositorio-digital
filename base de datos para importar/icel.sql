-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2025 a las 07:40:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `icel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_usuario` int(11) NOT NULL,
  `materia` varchar(150) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `archivo` varchar(500) NOT NULL,
  `id_archivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id_usuario`, `materia`, `titulo`, `archivo`, `id_archivo`) VALUES
(3, 'electronica', 'leyes de kirckof', '/icel/php/uploads/semana 4.pdf', 1),
(3, 'circuitos electricos', 'thevenin', '/icel/php/uploads/semana 4.pdf', 5),
(4, 'electronica', 'sumador operacional', '/icel/php/uploads/Diagrama en blanco (3).pdf', 6),
(4, 'fisica', 'leyes de newton', '/icel/php/uploads/CARTA DESCRIPTIVA  GLOBALIZACIÓN Y CONTEXTO SOCIOECONÓMICO DE MÉXICO  Grupo 4  C2-24.docx', 7),
(5, 'dfdf', 'fdgfd', '/icel/php/uploads/s12.py', 8),
(9, 'estructura de datos', 'uso de if,while', '/icel/php/uploads/semana 11 (1).pdf', 10),
(9, 'estructura de datos', 'programa de manejo de datos', '/icel/php/uploads/Semana12.pdf', 11),
(9, 'Globalización y Contexto Socioeconómico de México', 'Los buscadores y la tecnología de búsqueda', '/icel/php/uploads/gb3.pdf', 12),
(9, 'Globalización y Contexto Socioeconómico de México', 'fracaso a la nueva economia', '/icel/php/uploads/smn4.pdf', 13),
(9, 'electronica', 'calcular voltaje ', '/icel/php/uploads/WhatsApp Image 2024-05-31 at 8.02.03 PM.jpeg', 14),
(9, 'EMPRENDIMIENTO Y PLAN DE VIDA Y CARRERA', 'tipos de instrumentos de apoyo para empresas', '/icel/php/uploads/semana 9 (2).pdf', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contribuciones`
--

CREATE TABLE `contribuciones` (
  `id_usuario` int(11) NOT NULL,
  `proyecto` varchar(100) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `archivo` varchar(500) NOT NULL,
  `id_ar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `contribuciones`
--

INSERT INTO `contribuciones` (`id_usuario`, `proyecto`, `autor`, `archivo`, `id_ar`) VALUES
(4, 'pagina web', 'admin', '/icel/php/uploads/Curso de HTML.pdf', 2),
(3, 'ffxfcz', 'mazinkaiser', '/icel/php/uploads/semana 9.pdf', 3),
(5, 'electro', 'jose', '/icel/php/uploads/inventario.json', 5),
(9, 'repositorio digital', 'angel', '/icel/php/uploads/presentacion proyecto jose_compressed.pdf', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `pass` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`) VALUES
(3, 'mazinkaiser', '$2y$10$Fsand25K9WcXGszxt3EPcOJLLHvFGEk2Y.epyqkbOGanQuGOnWBVe'),
(4, 'admin', '$2y$10$5uyHkED8.De3hPdQK7CeUuJlzQBrsmWYV4YEwUBQNj83dxgZc6NDe'),
(5, 'jose', '$2y$10$dAUYcuOHjZqki9xm832yIuCwdVs2aw/tcX3elFr.k..NxXWZ7Lswm'),
(8, 'pedro', '$2y$10$lrX.ZCT0.BiYQCz5Wz2lIu1oxAvAIzzooB6bFrS1RxcEXIIkwWx4m'),
(9, 'angel', '$2y$10$MOxdTYE1ox3tX0mU4jhYXeXxLjO9.5xReV8UXH6LU7ib3IvWB4lVm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_archivo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `contribuciones`
--
ALTER TABLE `contribuciones`
  ADD PRIMARY KEY (`id_ar`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `contribuciones`
--
ALTER TABLE `contribuciones`
  MODIFY `id_ar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contribuciones`
--
ALTER TABLE `contribuciones`
  ADD CONSTRAINT `contribuciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
