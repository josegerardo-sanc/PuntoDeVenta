-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2020 a las 05:16:28
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `quesosbravo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonos`
--

CREATE TABLE `abonos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_ventas` bigint(20) UNSIGNED NOT NULL,
  `abono` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_corte` enum('no','yes') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_corte` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quien_r_corte` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `abonos`
--

INSERT INTO `abonos` (`id`, `id_ventas`, `abono`, `fecha`, `status_corte`, `fecha_corte`, `quien_r_corte`) VALUES
(1, 40, '100', '2020-01-03 01:58:03', 'yes', 'Viernes 2020-01-03 2:13 am', '1'),
(2, 40, '85', '2020-01-03 02:16:49', 'yes', 'Viernes 2020-01-03 2:17 am', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('no','yes') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion_p` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_cliente` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `negocio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_n` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_negocio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `cliente`, `tipo`, `status`, `telefono`, `direccion_p`, `img_cliente`, `negocio`, `direccion_n`, `img_negocio`) VALUES
(1, 'Luis Angel Sanchez Alvaradp', 'no', 'yes', '9321223455', 'col.esquipulas callejon san pedro', 'upload/12345persona_persona.jpg', '', '', 'upload/12345negocio_negocio.jpg'),
(2, 'Hugo', 'yes', 'yes', '9321223567', 'col.esquipulas callejon san pedro', 'upload/12345persona_persona.jpg', 'Taqueria La Braza', 'col.centro venida revolucion s/n  cs.roja', 'upload/12345negocio_negocio.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_precompras`
--

CREATE TABLE `detalle_precompras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `id_precompra` bigint(20) UNSIGNED NOT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_precompras`
--

INSERT INTO `detalle_precompras` (`id`, `id_producto`, `id_precompra`, `cantidad`) VALUES
(1, 7, 1, '1'),
(2, 1, 2, '1'),
(3, 2, 2, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_venta` enum('local','cliente') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `id_venta` bigint(20) UNSIGNED NOT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `tipo_venta`, `id_producto`, `id_venta`, `cantidad`, `precio`) VALUES
(1, 'local', 1, 37, '1', '90'),
(2, 'local', 2, 37, '1', '80'),
(3, 'local', 3, 37, '1', '100'),
(4, 'local', 4, 37, '1', '15'),
(5, 'local', 8, 38, '1', '50'),
(6, 'local', 7, 38, '1', '20'),
(7, 'local', 6, 38, '1', '110'),
(8, 'local', 5, 38, '1', '10'),
(9, 'local', 4, 39, '1', '15'),
(10, 'local', 8, 39, '1', '50'),
(11, 'local', 2, 39, '1', '80'),
(12, 'local', 6, 39, '1', '110'),
(13, 'local', 1, 39, '1', '90'),
(14, 'local', 4, 40, '1', '15'),
(15, 'local', 2, 40, '1', '80'),
(16, 'local', 1, 40, '1', '90'),
(17, 'local', 2, 41, '1', '80'),
(18, 'local', 1, 41, '1', '90'),
(19, 'local', 4, 42, '1', '15'),
(20, 'local', 1, 42, '1', '90'),
(21, 'local', 1, 43, '1', '90'),
(22, 'local', 8, 43, '1', '50'),
(23, 'local', 7, 43, '1', '20'),
(24, 'local', 6, 43, '1', '110'),
(25, 'cliente', 1, 44, '1', '95'),
(26, 'cliente', 2, 44, '1', '70'),
(27, 'local', 7, 44, '1', '20'),
(28, 'local', 6, 44, '1', '110');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_10_08_121022_create_productos_table', 1),
(4, '2019_10_11_215004_create_reabastecers_table', 1),
(5, '2019_10_15_234509_create_ventas_table', 1),
(6, '2019_10_18_053107_create_precompras_table', 1),
(7, '2019_10_18_053301_create_detalle_precompras_table', 1),
(8, '2019_10_19_054621_create_detalle_ventas_table', 1),
(9, '2019_11_01_100031_create_clientes_table', 1),
(10, '2019_12_13_020203_create_abonos_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precompras`
--

CREATE TABLE `precompras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numeroFactura` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `precompras`
--

INSERT INTO `precompras` (`id`, `numeroFactura`, `fecha`) VALUES
(1, 'RK1WKG0IKG', '2020-01-14 12:40:39'),
(2, 'RF66LKWEAB', '2020-03-06 22:08:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_producto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `negocio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentacion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `status`, `image_producto`, `nombre`, `local`, `negocio`, `presentacion`, `cantidad`, `stock`, `pedido`) VALUES
(1, '14912252433', 'yes', 'upload/Pte6zTtjmaiwav0axsK2Pqs7FEoWfAQRbHIVFpnU.jpeg', 'Queso De Hebra', '90', '95', '1kg', '112', '50', 1),
(2, '14912272449', 'yes', 'upload/RtfvIh4bfNqVPWZcauUEiDyPhFR9xyYgVNUseztY.jpeg', 'Queso Botanero', '80', '70', '900gr', '65', '100', 1),
(3, '14912282457', 'yes', 'upload/8rJtTL9F1Rd4CxbgF164gXZB8q4tZA0lNj7xDo2z.jpeg', 'Queso Crema', '100', '85', '900gr', '0', '50', 0),
(4, '14912282427', 'yes', 'upload/yU81uBTDHZ2PvBWkv1Dn216wmh2fd4CcHtassn4P.jpeg', 'Lechita Fria', '15', '12', '300ml', '0', '50', 0),
(5, '14001350216', 'yes', 'upload/d6oIimffNNjHL0KKo71mZjVUHvRPvGqseIm7JfDr.jpeg', 'Salsa Picante', '10', '8', '400ml', '28', '50', 0),
(6, '14001360237', 'yes', 'upload/Vw1TKpdAE8eJTt5ZrNjETGChVxnsxxYN9pnzL7aN.jpeg', 'Queso Panela', '110', '100', '1200gr', '35', '50', 0),
(7, '14001370237', 'yes', 'upload/a8aGXAVegH2ASyxiVPTLoo2zyDTYWZCj3dxEbxzX.jpeg', 'Tortillina', '20', '18', '500gr', '26', '50', 1),
(8, '14001380208', 'yes', 'upload/TxF8pJyppawxiWdMzxxyfUcJMKuLflRLsumIOnYN.jpeg', 'Rompope', '50', '45', '500ml', '46', '100', 0),
(9, '11002592051', 'yes', 'upload/L3zbjfne8xVSATH1RaipheqRN5GUnk4KPmSqOzaK.jpeg', 'Queso Numero 2', '90', '100', '1kg', '50', '30', NULL),
(10, '15002062026', 'yes', 'upload/HwNJhCBItF7OrdNMeiTmcT7thhV37UQ6ien2EoRR.jpeg', 'Tortillas5', '10', '15', '400gr', '30', '100', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reabastecers`
--

CREATE TABLE `reabastecers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reabastecers`
--

INSERT INTO `reabastecers` (`id`, `id_producto`, `cantidad`, `fecha`) VALUES
(1, 1, '56', '2020-01-26'),
(2, 1, '30', '2020-02-08'),
(3, 2, '50', '2020-02-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'jose gerardo sanchez alvarado', 'sanchezalvaradojose0@gmail.com', NULL, '$2y$10$fwOI5mqYPqW/x/kHiacA8OKLvekv22jWfZwA.asECY803GKW.ZVgm', NULL, '2020-01-03 07:53:17', '2020-01-03 07:53:17'),
(2, 'Maria del carmen zamudio herrera', 'chelablanca2012@gmail.com', NULL, '$2y$10$Kq2dWRcnP4Z4ElPDpUVT9OLLFr53AOoc5g5h01KiW0DynqKLEfJne', NULL, '2020-02-20 18:29:10', '2020-02-20 18:29:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `numerofactura` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta` enum('contado','credito') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_corte` enum('no','yes') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_corte` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quien_r_corte` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `id_usuario`, `numerofactura`, `fecha`, `hora`, `importe`, `venta`, `status_corte`, `fecha_corte`, `quien_r_corte`) VALUES
(37, '', 1, 'DGF2544IHZ', '2020-01-03', 'Viernes 1:55 am', '285', 'contado', 'yes', 'Viernes 2020-01-03 2:13 am', '1'),
(38, '', 1, 'ILTEZKVB3R', '2020-01-03', 'Viernes 1:56 am', '190', 'contado', 'yes', 'Viernes 2020-01-03 2:13 am', '1'),
(39, '', 1, 'UVAHYQ3E4B', '2020-01-03', 'Viernes 1:56 am', '345', 'contado', 'yes', 'Viernes 2020-01-03 2:13 am', '1'),
(40, '1', 1, 'CNYBUA8ZAE', '2020-01-03', 'Viernes 1:57 am', '185', 'credito', 'no', NULL, NULL),
(41, '', 1, 'RHUHQX1SYM', '2020-01-03', 'Viernes 10:28 am', '170', 'contado', 'yes', 'Sabado 2020-02-01 4:13 pm', '1'),
(42, '', 1, 'USQU302EFM', '2020-02-20', 'Jueves 12:04 pm', '105', 'contado', 'yes', 'Jueves 2020-02-20 12:24 pm', '1'),
(43, '', 2, '7VC7S6DJI8', '2020-02-20', 'Jueves 12:29 pm', '270', 'contado', 'yes', 'Jueves 2020-02-20 12:30 pm', '2'),
(44, '1', 1, 'G62ANO1MZ6', '2020-02-20', 'Jueves 3:02 pm', '295', 'contado', 'yes', 'Viernes 2020-03-06 9:58 pm', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonos`
--
ALTER TABLE `abonos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abonos_id_ventas_foreign` (`id_ventas`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_precompras`
--
ALTER TABLE `detalle_precompras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_precompras_id_producto_foreign` (`id_producto`),
  ADD KEY `detalle_precompras_id_precompra_foreign` (`id_precompra`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_id_producto_foreign` (`id_producto`),
  ADD KEY `detalle_ventas_id_venta_foreign` (`id_venta`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `precompras`
--
ALTER TABLE `precompras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reabastecers`
--
ALTER TABLE `reabastecers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reabastecers_id_producto_foreign` (`id_producto`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_id_usuario_foreign` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonos`
--
ALTER TABLE `abonos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_precompras`
--
ALTER TABLE `detalle_precompras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `precompras`
--
ALTER TABLE `precompras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reabastecers`
--
ALTER TABLE `reabastecers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abonos`
--
ALTER TABLE `abonos`
  ADD CONSTRAINT `abonos_id_ventas_foreign` FOREIGN KEY (`id_ventas`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `detalle_precompras`
--
ALTER TABLE `detalle_precompras`
  ADD CONSTRAINT `detalle_precompras_id_precompra_foreign` FOREIGN KEY (`id_precompra`) REFERENCES `precompras` (`id`),
  ADD CONSTRAINT `detalle_precompras_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_ventas_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `reabastecers`
--
ALTER TABLE `reabastecers`
  ADD CONSTRAINT `reabastecers_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
