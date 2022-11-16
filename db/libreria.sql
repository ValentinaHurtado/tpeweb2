-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2022 a las 06:01:44
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `Id_generos` int(11) NOT NULL,
  `Genero` varchar(100) NOT NULL,
  `Descripcion` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`Id_generos`, `Genero`, `Descripcion`) VALUES
(1, 'Fantasía', 'Cuenta con elementos que rompen con la realidad establecida y las normas que hay en esta. Caracterizado por elementos sobrenaturales y poco realistas.'),
(2, 'Ficción de aventuras', 'Suelen tener un protagonista como héroe que debe enfrentarse a situaciones fuera de lo común, riesgos, misterios y peligros. Generalmente cuentan con un final feliz.'),
(3, 'Distopía', 'Se centran en sociedades caracterizadas por tiranías, desastres ambientales o la deshumanización de las personas. Suelen estar ambientadas en el futuro y hacer una crítica o llamado de atención a nuestra sociedad actual.'),
(4, 'Ciencia ficción', 'Desarrolla escenarios imaginarios especulando sobre posibles avances científicos y tecnológicos y los impactos de estos en la sociedad.'),
(5, 'Terror', 'Se basa en afectar al lector con la intención de generar miedo o angustia, induciendo sentimientos de horror y terror.'),
(6, 'Policial', 'Suelen consistir en la resolución de un misterio de tipo criminal. Se presenta un problema deductivo que, por lo general, el protagonista debe resolver.'),
(7, 'Ficción', 'Se crea una realidad distinta a la que vivimos y narra hechos imaginarios. Generalmente, tiene un gran grado de realismo ya que toma elementos de referencia de la realidad.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `Id_libros` int(11) NOT NULL,
  `Titulo` varchar(100) NOT NULL,
  `Autores` varchar(75) NOT NULL,
  `Anio` int(11) NOT NULL,
  `Precio` double NOT NULL,
  `Generos_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`Id_libros`, `Titulo`, `Autores`, `Anio`, `Precio`, `Generos_fk`) VALUES
(197, 'Carrie', 'Stephen King', 1974, 1633, 5),
(198, 'El Cuento de la Criada', 'Margaret Atwood', 1985, 3199, 3),
(199, 'Cell', 'Stephen King', 2006, 4004, 5),
(200, 'Eran Diez', 'Agatha Christie', 1939, 2188, 6),
(201, 'Frankenstein o el moderno Prometeo', 'Mary Shelley', 1818, 1140, 4),
(202, 'Harry Potter y la Piedra Filosofal', 'JK Rowling', 1997, 3500, 1),
(203, 'Insurgente', 'Veronica Roth', 2012, 5249, 3),
(204, 'Los Juegos del Hambre', 'Suzanne Collins', 2008, 3644, 3),
(205, 'La vuelta al mundo en ochenta días', 'Julio Verne', 1872, 1140, 2),
(206, 'Mujercitas', 'Louisa May Alcott', 1868, 4904, 7),
(207, 'El Mago de Oz', 'Lyman Frank Baum', 1900, 1230, 1),
(208, 'Pequeñas Mentiras', ' Liane Moriarty', 2014, 5099, 6),
(209, 'Robinson Crusoe', 'Daniel Defoe', 1719, 2078, 2),
(210, 'Las Ventajas de ser Invisible', 'Steven Chbosky', 1999, 4099, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `Id_user` int(11) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`Id_user`, `Email`, `Password`) VALUES
(3, 'prueba@admin.com', '$2a$12$xYVEQKzhz7wHeVnBS3YEY.AqDD/y./ck4BmfD2a0HSRGe3awcSiWq');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`Id_generos`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`Id_libros`),
  ADD KEY `Generos_fk` (`Generos_fk`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id_user`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `Id_generos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `Id_libros` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `Id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`Generos_fk`) REFERENCES `generos` (`Id_generos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
