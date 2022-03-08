-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2020 a las 18:32:45
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_oscar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'asd', '2020-07-30 00:00:00', '0000-00-00 00:00:00'),
(2, 'hyperlink se', '2020-07-31 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `simulation`
--

CREATE TABLE `simulation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `variety_id` int(11) NOT NULL,
  `number_hectares_planted` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `soil_quality` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `total_rainfall` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `average_temperature_area` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `harvest` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `simulation`
--

INSERT INTO `simulation` (`id`, `user_id`, `variety_id`, `number_hectares_planted`, `soil_quality`, `total_rainfall`, `average_temperature_area`, `harvest`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '142', '100', '1600', '20', '12', '2020-10-08 12:35:24', '2020-10-17 10:19:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `simulation_users`
--

CREATE TABLE `simulation_users` (
  `id` int(11) NOT NULL,
  `simulacion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `simulation_users`
--

INSERT INTO `simulation_users` (`id`, `simulacion_id`, `user_id`, `created_at`) VALUES
(3, 1, 2, '2020-10-13 13:53:09'),
(4, 1, 2, '2020-10-13 14:11:36'),
(5, 1, 2, '2020-10-13 14:24:30'),
(6, 1, 2, '2020-10-17 10:19:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `username` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `slug` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `role` int(11) NOT NULL COMMENT '1: administrador, 2: asesor, 3:agronomo',
  `company` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telephone` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cc` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `_token` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `slug`, `password`, `role`, `company`, `telephone`, `cc`, `_token`, `created_at`, `updated_at`) VALUES
(1, 'Johan David Castro Palomares', 'johanca965@hotmail.com', 'johanca965-hotmail.com', '$2y$10$KuAYXec51hws3UUpPv4Tces6gZYF2GhqfifBU7t81YmlmJ0.N9eym', 3, 'NULL', '3222183956', '1099214218', '=k*.eWH0QI+Q|j1m&6;AVs2Q;YL3o4kp2GvbrbyOUZRy0\\%0qj^Wz435meyAw|xu,x+XKX2myTkzv&i?s0_0DQFXi!fNo@.X3?&L', '2020-07-30 03:46:21', '0000-00-00 00:00:00'),
(2, 'usuario de pruebas', 'test-user@hyperlinkse.com', 'test-user-hyperlinkse.com', '$2y$10$akmYNjJ3NnT0XD0iW3.AQuytMdCiy80R/d3tgt1FWnj81DvtRdQ8S', 2, 'hyperlink se', '3222183956', '123123123', ':@/1f#oVFAO#Xv#q^C,3sl4:;Q*05ZdEzu?3:EbHjDhqsrqApjc/,JGf?B2q^?bQC@e+LvWX%@kWp.CD&D3mtx1F:#3KmcFBnBLq', '2020-07-30 04:58:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variety`
--

CREATE TABLE `variety` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `month` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `variety`
--

INSERT INTO `variety` (`id`, `name`, `month`, `created_at`, `updated_at`) VALUES
(1, 'cc 93-7510', '16.1', '2020-08-02 00:00:00', NULL),
(2, 'cc 91-1555', '15.36', '2020-08-02 00:00:00', NULL),
(3, 'cc 92-2198', '17', '2020-08-02 00:00:00', NULL),
(4, 'variedad de control RD 75-11', '17', '2020-08-02 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variety_agroindustrial_properties`
--

CREATE TABLE `variety_agroindustrial_properties` (
  `id` int(11) NOT NULL,
  `variety_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1: jugos, 2:panela',
  `brix` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ph` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `sugars` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `saccharose` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `purity` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `phosphor` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `humidity` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `variety_agroindustrial_properties`
--

INSERT INTO `variety_agroindustrial_properties` (`id`, `variety_id`, `type`, `brix`, `ph`, `sugars`, `saccharose`, `purity`, `phosphor`, `humidity`, `created_at`) VALUES
(1, 1, 1, '21.3', '5.52', '0.9', '20', '93.9', '131', '', '2020-08-03 00:00:00'),
(2, 1, 2, '91.2', '5.75', '6', '84.2', '92.3', '449', '9.3', '2020-08-03 00:00:00'),
(3, 2, 1, '18.6', '5.31', '1.3', '17.2', '92.5', '239', '', '2020-08-03 00:00:00'),
(4, 2, 2, '92', '5.39', '10.5', '80.3', '87.3', '821', '8.7', '2020-08-03 00:00:00'),
(5, 3, 1, '21.1', '5.62', '1', '19.7', '93.4', '154', '', '2020-08-03 00:00:00'),
(6, 3, 2, '92', '5.72', '7.1', '83.3', '90.5', '483', '8.9', '2020-08-03 00:00:00'),
(7, 4, 1, '19.2', '5.7', '0.9', '18.2', '94.8', '66', '', '2020-08-03 00:00:00'),
(8, 4, 2, '92.4', '5.8', '6.8', '85', '92', '220', '7.9', '2020-08-03 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variety_properties`
--

CREATE TABLE `variety_properties` (
  `id` int(11) NOT NULL,
  `variety_id` int(11) NOT NULL,
  `natural_defoliation` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `overturning_stems` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `flowering` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `bark_crack` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `presence_laslas_chulquines` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `lint_content` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `average_plant_height` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `stem_diameter` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `internode_length` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `growth_rate_cm` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `growth_rate_entrenudo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `grinding_stems_time_cutting` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `cane_production` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `bud_production_seed` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `palm_production_green_leaves` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `panela_production` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `yield_panela` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `cachaca_production` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `melote_production` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `green_bagasse_production` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `variety_properties`
--

INSERT INTO `variety_properties` (`id`, `variety_id`, `natural_defoliation`, `overturning_stems`, `flowering`, `bark_crack`, `presence_laslas_chulquines`, `lint_content`, `average_plant_height`, `stem_diameter`, `internode_length`, `growth_rate_cm`, `growth_rate_entrenudo`, `grinding_stems_time_cutting`, `cane_production`, `bud_production_seed`, `palm_production_green_leaves`, `panela_production`, `yield_panela`, `cachaca_production`, `melote_production`, `green_bagasse_production`, `created_at`) VALUES
(1, 1, 'Fácil', 'No', 'Ausente', 'No', 'No', 'Escasa', '2.91', '2.97', '11.43', '18.05', '1.59', '133328.00', '208.8', '21.41', '34.79', '26.5', '12.69', '11.76', '6.57', '120', '2020-08-02 00:00:00'),
(2, 2, 'Fácil', 'No', 'Ausente', 'No', 'No', 'Abundante', '2.85', '2.93', '10.61', '18.55', '1.76', '106406', '181.52', '27.59', '59.44', '21.80', '12.01', '10.56', '5.8', '72.82', '2020-08-02 00:00:00'),
(3, 3, 'Regular', 'No', 'Ausente', 'No', 'No', 'Abundante', '2.82', '3.17', '10.06', '15.93', '1.86', '84612', '164.1', '15.23', '27.07', '21.7', '13.20', '4.71', '2.59', '67.64', '2020-08-02 00:00:00'),
(4, 4, 'Difícil', 'No', 'Ausente', 'No', 'No', 'Ausente', '3.56', '3.46', '10.33', '20.09', '1.94', '94868.00', '247.63', '27.13', '56.53', '30.80', '11.36', '6.38', '3.51', '114.64', '2020-08-02 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `simulation`
--
ALTER TABLE `simulation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `variety_id` (`variety_id`);

--
-- Indices de la tabla `simulation_users`
--
ALTER TABLE `simulation_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `simulacion_id` (`simulacion_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `variety`
--
ALTER TABLE `variety`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `variety_agroindustrial_properties`
--
ALTER TABLE `variety_agroindustrial_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variety_id` (`variety_id`);

--
-- Indices de la tabla `variety_properties`
--
ALTER TABLE `variety_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variety_id` (`variety_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `simulation`
--
ALTER TABLE `simulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `simulation_users`
--
ALTER TABLE `simulation_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `variety`
--
ALTER TABLE `variety`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `variety_agroindustrial_properties`
--
ALTER TABLE `variety_agroindustrial_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `variety_properties`
--
ALTER TABLE `variety_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `simulation`
--
ALTER TABLE `simulation`
  ADD CONSTRAINT `simulation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simulation_ibfk_2` FOREIGN KEY (`variety_id`) REFERENCES `variety` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `variety_agroindustrial_properties`
--
ALTER TABLE `variety_agroindustrial_properties`
  ADD CONSTRAINT `variety_agroindustrial_properties_ibfk_1` FOREIGN KEY (`variety_id`) REFERENCES `variety` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `variety_properties`
--
ALTER TABLE `variety_properties`
  ADD CONSTRAINT `variety_properties_ibfk_1` FOREIGN KEY (`variety_id`) REFERENCES `variety` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
