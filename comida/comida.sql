-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-06-2026 a las 01:16:39
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
-- Base de datos: `comida`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE `comidas` (
  `id_comida` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fk_seccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comidas`
--

INSERT INTO `comidas` (`id_comida`, `nombre`, `precio`, `imagen`, `descripcion`, `fk_seccion`) VALUES
(12, 'Milanesa con Papas fritas', 13000.00, NULL, NULL, NULL),
(13, 'Brownie con Helado', 18000.00, NULL, 'Brownie con helado de vainilla, salsa de chocolate y salsa de dulce de leche.', 6),
(15, 'Hamburguesa Luka´s', 16500.00, NULL, NULL, NULL),
(16, 'Pasta Carbonara', 15300.00, NULL, NULL, NULL),
(17, 'Ensalada César', 21000.00, NULL, 'Ensalada César cargada con lechuga, pechuga de pollo salteada, tostadas del mejor pan, y la salsa césar local.', NULL),
(18, 'Pizza Margarita', 17800.00, NULL, 'Pizza Margarita clásica con Albaca, mozzarella, tomate natural, y oliva virgen extra.', 4),
(19, 'Risoto de Hongos', 14300.00, NULL, 'El mejor Arroz servido con su mejor presentación, colorido con sabrosos champiñones.', 9),
(20, 'Salmon a la plancha', 15400.00, NULL, NULL, NULL),
(22, 'Coca Cola Zero', 2400.00, NULL, '', 10),
(23, 'Pizza de Rúcula', 16300.00, NULL, NULL, 4),
(24, 'Pizza de Hongos especial', 18300.00, NULL, NULL, 4),
(25, 'Sprite 500ml', 2400.00, NULL, '', 10),
(26, 'Levite de Manzana 480ml', 1900.00, NULL, '', 10),
(27, 'Aquarius Pera1,5L', 3200.00, NULL, '', 10),
(29, 'Vino Rutini 600ml', 23400.00, NULL, 'Vino rutini cosecha añeja 600 ml', 8),
(30, 'Rabas fritas', 21000.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado`) VALUES
(1, 'activo'),
(2, 'banneado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

CREATE TABLE `secciones` (
  `id_seccion` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id_seccion`, `nombre`) VALUES
(4, 'Pizzas'),
(6, 'Postres'),
(8, 'Vinos'),
(9, 'Entradas'),
(10, 'Bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuarios`
--

CREATE TABLE `tipos_usuarios` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_usuarios`
--

INSERT INTO `tipos_usuarios` (`id_tipo_usuario`, `tipo`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `fk_estado` int(11) NOT NULL,
  `fk_tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `correo`, `clave`, `fk_estado`, `fk_tipo_usuario`) VALUES
(1, 'Bautista', 'carloni', 'bautista@dv.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 2),
(2, 'Leonardo', 'Davinci', 'leo@dv.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2),
(3, 'Miguel', 'Angel', 'miguel@angel.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2),
(4, 'Luca', 'Romano', 'lucaromano172@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 1),
(5, 'Nicolas', 'Ferreyra', 'nico@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 2, 2),
(6, 'Pablo', 'Pablito', 'pablito@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2),
(7, 'Luca', 'castellano', 'luc@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2),
(8, 'Celeste', 'ria', 'celeste@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2),
(9, 'Jose', 'Velez', 'jose@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2),
(10, 'marcelo', 'fernandez', 'Marcelo@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2),
(11, 'Jeremiaz', 'Tomillo', 'jere@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD PRIMARY KEY (`id_comida`),
  ADD KEY `fk_comida_seccion` (`fk_seccion`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `id_estado_UNIQUE` (`id_estado`);

--
-- Indices de la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id_seccion`),
  ADD UNIQUE KEY `id_seccion_UNIQUE` (`id_seccion`);

--
-- Indices de la tabla `tipos_usuarios`
--
ALTER TABLE `tipos_usuarios`
  ADD PRIMARY KEY (`id_tipo_usuario`),
  ADD UNIQUE KEY `id_tipo_usuario_UNIQUE` (`id_tipo_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `id_usuario_UNIQUE` (`id_usuario`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comidas`
--
ALTER TABLE `comidas`
  MODIFY `id_comida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipos_usuarios`
--
ALTER TABLE `tipos_usuarios`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD CONSTRAINT `fk_comida_seccion` FOREIGN KEY (`fk_seccion`) REFERENCES `secciones` (`id_seccion`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
