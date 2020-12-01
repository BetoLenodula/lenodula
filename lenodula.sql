-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2020 at 12:46 PM
-- Server version: 5.7.32-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lenodula`
--

-- --------------------------------------------------------

--
-- Table structure for table `archivos_respuesta`
--

CREATE TABLE `archivos_respuesta` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_tema` int(11) NOT NULL,
  `id_archivo` varchar(19) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_archivo` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `mime_archivo` varchar(254) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_archivo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archivos_tema`
--

CREATE TABLE `archivos_tema` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_tema` int(11) NOT NULL,
  `id_archivo` varchar(19) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_archivo` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `mime_archivo` varchar(254) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_archivo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comentarios_grupo`
--

CREATE TABLE `comentarios_grupo` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `comentario` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `hashtags` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `numero_reportes` int(2) NOT NULL,
  `fecha_comentario` date NOT NULL,
  `numero_respuestas_comentario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_evento` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_evento` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `dia_evento` int(2) NOT NULL,
  `mes_evento` int(2) NOT NULL,
  `anio_evento` int(4) NOT NULL,
  `hora_evento` time NOT NULL,
  `url_referencia` varchar(125) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
--
-- Table structure for table `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `foto_grupo` varchar(36) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_grupo` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_grupo` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_acceso` varchar(7) COLLATE utf8_spanish_ci NOT NULL,
  `theme` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `color_theme` varchar(7) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion_grupo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guesses_words`
--

CREATE TABLE `guesses_words` (
  `id` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `nombre_guesswrd` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `image_guesswrd` text COLLATE utf8_spanish_ci NOT NULL,
  `words` varchar(400) COLLATE utf8_spanish_ci NOT NULL,
  `clues` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_guesswrd` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materias_cursos`
--

CREATE TABLE `materias_cursos` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `nombre_materia_curso` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion_materia_curso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_emisor` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_receptor` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` varchar(800) COLLATE utf8_spanish_ci NOT NULL,
  `timestamp_mensaje` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mensaje_visto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `miembros_grupo`
--

CREATE TABLE `miembros_grupo` (
  `id` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_agregado` date NOT NULL,
  `acceso_grupo` tinyint(1) NOT NULL,
  `status_miembro` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones_grupo`
--

CREATE TABLE `notificaciones_grupo` (
  `id` int(11) NOT NULL,
  `id_emisor` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_receptor` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `notificacion_grupo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_notificacion_grupo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones_respuestas_tema`
--

CREATE TABLE `notificaciones_respuestas_tema` (
  `id` int(11) NOT NULL,
  `tipo_notificacion` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `id_emisor` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_receptor` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `notificacion_respuesta_tema` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `fecha_notificacion_respuesta_tema` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reportes_respuesta`
--

CREATE TABLE `reportes_respuesta` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_respuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_tema` int(11) NOT NULL,
  `titulo_respuesta` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `respuesta` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `timestamp_respuesta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `numero_respuestas` int(11) NOT NULL,
  `gratificaciones` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `total_reportes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `respuestas_comentarios_grupo`
--

CREATE TABLE `respuestas_comentarios_grupo` (
  `id` int(11) NOT NULL,
  `id_comentario` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_page` int(11) NOT NULL,
  `respuesta_comentario` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_respuesta_comentario` date NOT NULL,
  `vista_respuesta_comentario` tinyint(1) NOT NULL,
  `mencion` varchar(16) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `respuestas_respuesta`
--

CREATE TABLE `respuestas_respuesta` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `respuesta_respuesta` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `timestamp_respuesta_respuesta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stream`
--

CREATE TABLE `stream` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `stream_tipo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_stream` date NOT NULL,
  `id_comentario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temas_materia_curso`
--

CREATE TABLE `temas_materia_curso` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_materia_curso` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `contenido` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `tags` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `fecha_limite_respuesta` date DEFAULT NULL,
  `hora_limite_respuesta` time DEFAULT NULL,
  `permiso_archivo` tinyint(1) NOT NULL,
  `nivel_tema` tinyint(1) NOT NULL,
  `likes_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temas_vistos`
--

CREATE TABLE `temas_vistos` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timelines`
--

CREATE TABLE `timelines` (
  `id` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `nombre_timeline` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `image_timeline` text COLLATE utf8_spanish_ci NOT NULL,
  `fechas` varchar(400) COLLATE utf8_spanish_ci NOT NULL,
  `datos` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_timeline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `id_materia_curso` int(11) NOT NULL,
  `nombre_unidad` varchar(80) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `ids` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `identificador_unico` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(17) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_user` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `rol` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `codigo_activacion` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `total_respuestas` int(11) NOT NULL,
  `total_puntos` int(11) NOT NULL,
  `total_gratificaciones` int(11) NOT NULL,
  `enlinea` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_comentario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votos_encuesta`
--

CREATE TABLE `votos_encuesta` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_comentario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votos_gratifica`
--

CREATE TABLE `votos_gratifica` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_respuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votos_tema`
--

CREATE TABLE `votos_tema` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `id_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `word_finds`
--

CREATE TABLE `word_finds` (
  `id` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `nombre_wrdfnd` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `words_wrdfnd` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_wrdfnd` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Structure for view `full_notificaciones_comentarios`
--
DROP TABLE IF EXISTS `full_notificaciones_comentarios`;

CREATE VIEW `full_notificaciones_comentarios`  AS  select `respuestas_comentarios_grupo`.`id` AS `id`,`usuarios`.`foto` AS `foto`,`usuarios`.`nombre_user` AS `nombre_user`,`comentarios_grupo`.`id_usuario` AS `id_receptor`,`comentarios_grupo`.`id_grupo` AS `id_grupo`,`grupos`.`nombre_grupo` AS `nombre_grupo`,`respuestas_comentarios_grupo`.`id_usuario` AS `id_emisor`,`comentarios_grupo`.`id` AS `id_post`,`respuestas_comentarios_grupo`.`id_page` AS `id_page`,`respuestas_comentarios_grupo`.`fecha_respuesta_comentario` AS `fecha`,`respuestas_comentarios_grupo`.`mencion` AS `mencion` from (((`usuarios` join `comentarios_grupo`) join `grupos`) join `respuestas_comentarios_grupo`) where ((`usuarios`.`identificador_unico` = `respuestas_comentarios_grupo`.`id_usuario`) and (`grupos`.`id` = `comentarios_grupo`.`id_grupo`) and (`respuestas_comentarios_grupo`.`id_comentario` = `comentarios_grupo`.`id`) and (`respuestas_comentarios_grupo`.`vista_respuesta_comentario` = 0)) ;

-- --------------------------------------------------------

--
-- Structure for view `full_notificaciones_grupo`
--
DROP TABLE IF EXISTS `full_notificaciones_grupo`;

CREATE VIEW `full_notificaciones_grupo`  AS  select `notificaciones_grupo`.`id` AS `id`,`notificaciones_grupo`.`notificacion_grupo` AS `notificacion_grupo`,`notificaciones_grupo`.`fecha_notificacion_grupo` AS `fecha_notificacion_grupo`,`notificaciones_grupo`.`id_emisor` AS `id_emisor`,`notificaciones_grupo`.`id_receptor` AS `id_receptor`,`notificaciones_grupo`.`id_grupo` AS `id_grupo`,`usuarios`.`nombre_user` AS `nombre_user`,`usuarios`.`foto` AS `foto`,`grupos`.`nombre_grupo` AS `nombre_grupo` from ((`notificaciones_grupo` join `usuarios` on((`notificaciones_grupo`.`id_emisor` = `usuarios`.`identificador_unico`))) join `grupos` on((`notificaciones_grupo`.`id_grupo` = `grupos`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `full_notificaciones_respuestas`
--
DROP TABLE IF EXISTS `full_notificaciones_respuestas`;

CREATE VIEW `full_notificaciones_respuestas`  AS  select `usuarios`.`nombre_user` AS `nombre_user`,`usuarios`.`foto` AS `foto`,`notificaciones_respuestas_tema`.`id` AS `id`,`notificaciones_respuestas_tema`.`tipo_notificacion` AS `tipo_notificacion`,`notificaciones_respuestas_tema`.`id_emisor` AS `id_emisor`,`notificaciones_respuestas_tema`.`id_receptor` AS `id_receptor`,`notificaciones_respuestas_tema`.`notificacion_respuesta_tema` AS `notificacion_respuesta_tema`,`notificaciones_respuestas_tema`.`id_respuesta` AS `id_respuesta`,`notificaciones_respuestas_tema`.`fecha_notificacion_respuesta_tema` AS `fecha_notificacion_respuesta_tema`,`respuestas`.`id_tema` AS `id_tema`,`temas_materia_curso`.`titulo` AS `titulo` from (((`usuarios` join `notificaciones_respuestas_tema`) join `respuestas`) join `temas_materia_curso`) where ((`usuarios`.`identificador_unico` = `notificaciones_respuestas_tema`.`id_emisor`) and (`notificaciones_respuestas_tema`.`id_respuesta` = `respuestas`.`id`) and (`respuestas`.`id_tema` = `temas_materia_curso`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `full_notificaciones_temas`
--
DROP TABLE IF EXISTS `full_notificaciones_temas`;

CREATE VIEW `full_notificaciones_temas`  AS  select `temas_materia_curso`.`id_usuario` AS `id_emisor`,`miembros_grupo`.`id_usuario` AS `id_receptor`,`temas_materia_curso`.`titulo` AS `titulo`,`temas_materia_curso`.`id` AS `id`,`temas_materia_curso`.`fecha_publicacion` AS `fecha_publicacion`,`temas_materia_curso`.`nivel_tema` AS `nivel_tema`,`usuarios`.`nombre_user` AS `nombre_user`,(curdate() - interval 3 day) AS `fecha_rango_limite` from (((`temas_materia_curso` join `miembros_grupo`) join `materias_cursos`) join `usuarios`) where ((`temas_materia_curso`.`id_usuario` = `usuarios`.`identificador_unico`) and (`temas_materia_curso`.`id_materia_curso` = `materias_cursos`.`id`) and (`materias_cursos`.`id_grupo` = `miembros_grupo`.`id_grupo`) and (`temas_materia_curso`.`contenido` <> '&lt;br&gt;') and (`miembros_grupo`.`acceso_grupo` = 1) and (`miembros_grupo`.`status_miembro` = 1)) ;

-- --------------------------------------------------------

--
-- Structure for view `full_view_puntos_grupo`
--
DROP TABLE IF EXISTS `full_view_puntos_grupo`;

CREATE VIEW `full_view_puntos_grupo`  AS  select `respuestas`.`calificacion` AS `calificacion`,`respuestas`.`gratificaciones` AS `gratificaciones`,`materias_cursos`.`id_grupo` AS `id_grupo`,`respuestas`.`id_usuario` AS `id_usuario` from ((`respuestas` join `materias_cursos`) join `temas_materia_curso`) where ((`respuestas`.`id_tema` = `temas_materia_curso`.`id`) and (`temas_materia_curso`.`id_materia_curso` = `materias_cursos`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `full_view_stream`
--
DROP TABLE IF EXISTS `full_view_stream`;

CREATE VIEW `full_view_stream`  AS  select `stream`.`id` AS `id`,`stream`.`stream_tipo` AS `stream_tipo`,`stream`.`id_grupo` AS `id_grupo`,`grupos`.`nombre_grupo` AS `nombre_grupo`,`grupos`.`theme` AS `theme`,`grupos`.`color_theme` AS `color_theme`,`usuarios`.`nombre_user` AS `nombre_user`,`usuarios`.`foto` AS `foto`,`stream`.`id_usuario` AS `id_usuario`,`stream`.`fecha_stream` AS `fecha_stream`,(select `comentarios_grupo`.`comentario` from `comentarios_grupo` where (`stream`.`id_comentario` = `comentarios_grupo`.`id`)) AS `comentario`,`stream`.`id_comentario` AS `id_comentario` from ((`grupos` join `usuarios`) join `stream`) where ((`stream`.`id_grupo` = `grupos`.`id`) and (`usuarios`.`identificador_unico` = `stream`.`id_usuario`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archivos_respuesta`
--
ALTER TABLE `archivos_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `archivos_tema`
--
ALTER TABLE `archivos_tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `comentarios_grupo`
--
ALTER TABLE `comentarios_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indexes for table `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `guesses_words`
--
ALTER TABLE `guesses_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `materias_cursos`
--
ALTER TABLE `materias_cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_ibfk_1` (`id_emisor`);

--
-- Indexes for table `miembros_grupo`
--
ALTER TABLE `miembros_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indexes for table `notificaciones_grupo`
--
ALTER TABLE `notificaciones_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indexes for table `notificaciones_respuestas_tema`
--
ALTER TABLE `notificaciones_respuestas_tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indexes for table `reportes_respuesta`
--
ALTER TABLE `reportes_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indexes for table `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `respuestas_comentarios_grupo`
--
ALTER TABLE `respuestas_comentarios_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comentario` (`id_comentario`);

--
-- Indexes for table `respuestas_respuesta`
--
ALTER TABLE `respuestas_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indexes for table `stream`
--
ALTER TABLE `stream`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indexes for table `temas_materia_curso`
--
ALTER TABLE `temas_materia_curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia_curso` (`id_materia_curso`);

--
-- Indexes for table `temas_vistos`
--
ALTER TABLE `temas_vistos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `timelines`
--
ALTER TABLE `timelines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia_curso` (`id_materia_curso`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`identificador_unico`);

--
-- Indexes for table `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comentario` (`id_comentario`);

--
-- Indexes for table `votos_encuesta`
--
ALTER TABLE `votos_encuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comentario` (`id_comentario`);

--
-- Indexes for table `votos_gratifica`
--
ALTER TABLE `votos_gratifica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indexes for table `votos_tema`
--
ALTER TABLE `votos_tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `word_finds`
--
ALTER TABLE `word_finds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tema` (`id_tema`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archivos_respuesta`
--
ALTER TABLE `archivos_respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archivos_tema`
--
ALTER TABLE `archivos_tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comentarios_grupo`
--
ALTER TABLE `comentarios_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guesses_words`
--
ALTER TABLE `guesses_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materias_cursos`
--
ALTER TABLE `materias_cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `miembros_grupo`
--
ALTER TABLE `miembros_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificaciones_grupo`
--
ALTER TABLE `notificaciones_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificaciones_respuestas_tema`
--
ALTER TABLE `notificaciones_respuestas_tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reportes_respuesta`
--
ALTER TABLE `reportes_respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `respuestas_comentarios_grupo`
--
ALTER TABLE `respuestas_comentarios_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `respuestas_respuesta`
--
ALTER TABLE `respuestas_respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stream`
--
ALTER TABLE `stream`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temas_materia_curso`
--
ALTER TABLE `temas_materia_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temas_vistos`
--
ALTER TABLE `temas_vistos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timelines`
--
ALTER TABLE `timelines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `votos_encuesta`
--
ALTER TABLE `votos_encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `votos_gratifica`
--
ALTER TABLE `votos_gratifica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `votos_tema`
--
ALTER TABLE `votos_tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `word_finds`
--
ALTER TABLE `word_finds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archivos_respuesta`
--
ALTER TABLE `archivos_respuesta`
  ADD CONSTRAINT `archivos_respuesta_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `archivos_tema`
--
ALTER TABLE `archivos_tema`
  ADD CONSTRAINT `archivos_tema_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comentarios_grupo`
--
ALTER TABLE `comentarios_grupo`
  ADD CONSTRAINT `comentarios_grupo_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`identificador_unico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`identificador_unico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guesses_words`
--
ALTER TABLE `guesses_words`
  ADD CONSTRAINT `guesses_words_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materias_cursos`
--
ALTER TABLE `materias_cursos`
  ADD CONSTRAINT `materias_cursos_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`identificador_unico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `miembros_grupo`
--
ALTER TABLE `miembros_grupo`
  ADD CONSTRAINT `miembros_grupo_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notificaciones_grupo`
--
ALTER TABLE `notificaciones_grupo`
  ADD CONSTRAINT `notificaciones_grupo_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notificaciones_respuestas_tema`
--
ALTER TABLE `notificaciones_respuestas_tema`
  ADD CONSTRAINT `notificaciones_respuestas_tema_ibfk_1` FOREIGN KEY (`id_respuesta`) REFERENCES `respuestas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reportes_respuesta`
--
ALTER TABLE `reportes_respuesta`
  ADD CONSTRAINT `reportes_respuesta_ibfk_1` FOREIGN KEY (`id_respuesta`) REFERENCES `respuestas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `respuestas_comentarios_grupo`
--
ALTER TABLE `respuestas_comentarios_grupo`
  ADD CONSTRAINT `respuestas_comentarios_grupo_ibfk_1` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios_grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `respuestas_respuesta`
--
ALTER TABLE `respuestas_respuesta`
  ADD CONSTRAINT `respuestas_respuesta_ibfk_1` FOREIGN KEY (`id_respuesta`) REFERENCES `respuestas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stream`
--
ALTER TABLE `stream`
  ADD CONSTRAINT `stream_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temas_materia_curso`
--
ALTER TABLE `temas_materia_curso`
  ADD CONSTRAINT `temas_materia_curso_ibfk_1` FOREIGN KEY (`id_materia_curso`) REFERENCES `materias_cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temas_vistos`
--
ALTER TABLE `temas_vistos`
  ADD CONSTRAINT `temas_vistos_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timelines`
--
ALTER TABLE `timelines`
  ADD CONSTRAINT `timelines_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unidades`
--
ALTER TABLE `unidades`
  ADD CONSTRAINT `unidades_ibfk_1` FOREIGN KEY (`id_materia_curso`) REFERENCES `materias_cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios_grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votos_encuesta`
--
ALTER TABLE `votos_encuesta`
  ADD CONSTRAINT `votos_encuesta_ibfk_1` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios_grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votos_gratifica`
--
ALTER TABLE `votos_gratifica`
  ADD CONSTRAINT `votos_gratifica_ibfk_1` FOREIGN KEY (`id_respuesta`) REFERENCES `respuestas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votos_tema`
--
ALTER TABLE `votos_tema`
  ADD CONSTRAINT `votos_tema_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `word_finds`
--
ALTER TABLE `word_finds`
  ADD CONSTRAINT `word_finds_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_materia_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
