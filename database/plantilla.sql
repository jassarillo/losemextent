-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-08-2020 a las 21:24:39
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plantilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(4) NOT NULL,
  `menu` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `padre` int(4) NOT NULL,
  `orden` int(2) NOT NULL,
  `activo` int(11) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `ruta` varchar(50) DEFAULT NULL,
  `ajax` varchar(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `menu`, `slug`, `padre`, `orden`, `activo`, `descripcion`, `ruta`, `ajax`, `created_at`, `updated_at`) VALUES
(1, 'Opción 1', 'opcion1', 0, 0, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(2, 'Opción 2', 'opcion2', 0, 1, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(3, 'Opción 3', 'opcion3', 0, 2, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(4, 'Opción 4', 'opcion4', 0, 3, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(5, 'Opción 1.1', 'opcion-1.1', 1, 0, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(6, 'Opción 1.2', 'opcion-1.2', 1, 1, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(7, 'Opción 3.1', 'opcion-3.1', 3, 0, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(8, 'Opción 3.2', 'opcion-3.2', 3, 1, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(9, 'Opción 4.1', 'opcion-4.1', 4, 0, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(10, 'Opción 3.2.1', 'opcion-3.2.1', 8, 0, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(11, 'Opción 3.2.2', 'opcion-3.2.2', 8, 1, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32'),
(12, 'Opción 3.2.3', 'opcion-3.2.3', 8, 2, 1, NULL, '/home', NULL, '2020-08-28 20:28:32', '2020-08-28 20:28:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_menu_permissions`
--

DROP TABLE IF EXISTS `model_has_menu_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_menu_permissions` (
  `id` int(8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` int(4) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` int(4) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` int(8) NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'AppUser', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'web', NULL, NULL),
(2, 'Admin', 'web', NULL, NULL),
(3, 'Ver', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'web', NULL, NULL),
(2, 'admin', 'web', NULL, NULL),
(3, 'SinAsignar', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` int(4) NOT NULL,
  `role_id` int(4) NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `apellido_paterno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido_materno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatares/avatar_neutro.jpeg',
  `estatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_rol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rfc` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `confirmed`, `confirmation_code`, `remember_token`, `created_at`, `updated_at`, `apellido_paterno`, `apellido_materno`, `usuario`, `avatar`, `estatus`, `id_rol`, `rfc`) VALUES
(1, 'uiu', 'jas@g.com', NULL, '$2y$10$aG47QfL6hikw.YfHnKfOaOVbzuNNmapypJTfoYwfIEhL7ZRfE7kuW', 0, 'nPS2Va97dAZxaop5YVQKyESD9', NULL, '2020-08-28 20:53:46', '2020-08-28 20:53:46', 'iuiu', 'uiu', 'jas', 'avatares/avatar_neutro.jpeg', '0', NULL, NULL),
(2, 'user', 'j@g.com', '2020-08-28 15:56:40', '$2y$10$964LYU0HFf1N.1B/eLcvTuhGwr9JddMI15U68c29dNkhV3WMt./Ii', 0, NULL, NULL, NULL, NULL, 'ee', 'ee', 'admin', 'avatares/avatar_neutro.jpeg', '1', '1', 'UYUYUYUYU');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
