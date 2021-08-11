-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 12, 2020 at 01:20 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestao_ideias`
--

-- --------------------------------------------------------

--
-- Table structure for table `DOCUMENTO_AVALIACAO`
--

CREATE TABLE `DOCUMENTO_AVALIACAO` (
  `ID` int(11) NOT NULL,
  `COD_USUARIO` int(11) DEFAULT NULL,
  `COD_IDEIA` int(11) DEFAULT NULL,
  `COD_TIPO` int(11) DEFAULT NULL,
  `COD_JUSTIFICATIVA` int(11) DEFAULT NULL,
  `LINK` varchar(255) DEFAULT NULL,
  `CRIACAO` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `EMPRESA`
--

CREATE TABLE `EMPRESA` (
  `NOME` varchar(100) DEFAULT NULL,
  `MODELO_PLANO_PROJETO` varchar(255) DEFAULT NULL,
  `MODELO_CHECK_LIST` varchar(255) DEFAULT NULL,
  `MODELO_VIABILIDADE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `EMPRESA`
--

INSERT INTO `EMPRESA` (`NOME`, `MODELO_PLANO_PROJETO`, `MODELO_CHECK_LIST`, `MODELO_VIABILIDADE`) VALUES
('Gestão e Armazenamento de Ideias', 'https://www.google.com', 'https://www.google.com', 'https://www.google.com');

-- --------------------------------------------------------

--
-- Table structure for table `ESTADO`
--

CREATE TABLE `ESTADO` (
  `CODIGO` int(11) NOT NULL,
  `TIPO` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ESTADO`
--

INSERT INTO `ESTADO` (`CODIGO`, `TIPO`) VALUES
(1, 'Pendente'),
(2, 'Preenchimento'),
(3, 'Registrada'),
(4, 'Viável'),
(5, 'Executando'),
(6, 'Implementada'),
(7, 'Cancelada');

-- --------------------------------------------------------

--
-- Table structure for table `IDEIA`
--

CREATE TABLE `IDEIA` (
  `ID` int(11) NOT NULL,
  `TITULO` varchar(255) DEFAULT NULL,
  `DESCRICAO` varchar(255) DEFAULT NULL,
  `LINK` varchar(255) DEFAULT NULL,
  `CRIACAO` datetime DEFAULT current_timestamp(),
  `COD_USUARIO` int(11) DEFAULT NULL,
  `COD_ESTADO` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `JUSTIFICATIVA`
--

CREATE TABLE `JUSTIFICATIVA` (
  `CODIGO` int(11) NOT NULL,
  `TIPO` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `JUSTIFICATIVA`
--

INSERT INTO `JUSTIFICATIVA` (`CODIGO`, `TIPO`) VALUES
(1, 'Duplicada'),
(2, 'Inviável'),
(3, 'Viável');

-- --------------------------------------------------------

--
-- Table structure for table `PAPEL`
--

CREATE TABLE `PAPEL` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(25) DEFAULT NULL,
  `PERMISSAO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PAPEL`
--

INSERT INTO `PAPEL` (`ID`, `NOME`, `PERMISSAO`) VALUES
(1, 'ADMIN', 0),
(2, 'REVISÃO', 1),
(3, 'EQUIPE DE INOVAÇÃO', 2),
(4, 'COLABORADOR', 3),
(5, 'PATROCINADOR', 4);

-- --------------------------------------------------------

--
-- Table structure for table `TESTE`
--

CREATE TABLE `TESTE` (
  `ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TIPO`
--

CREATE TABLE `TIPO` (
  `CODIGO` int(11) NOT NULL,
  `TIPO` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TIPO`
--

INSERT INTO `TIPO` (`CODIGO`, `TIPO`) VALUES
(1, 'Avaliação Inicial'),
(2, 'Plano de Projeto'),
(3, 'Avaliação de Viabilidade'),
(4, 'Avaliação de Seleção');

-- --------------------------------------------------------

--
-- Table structure for table `USUARIO`
--

CREATE TABLE `USUARIO` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(50) DEFAULT NULL,
  `FOTO` blob DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `SENHA` varchar(64) DEFAULT NULL,
  `CONTA` char(1) DEFAULT 'N',
  `CRIACAO` datetime DEFAULT current_timestamp(),
  `COD_PAPEL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USUARIO`
--

INSERT INTO `USUARIO` (`ID`, `NOME`, `FOTO`, `EMAIL`, `SENHA`, `CONTA`, `CRIACAO`, `COD_PAPEL`) VALUES
(1, 'admin', NULL, 'admin@email.com.br', '81dc9bdb52d04dc20036dbd8313ed055', 'N', '2019-11-15 22:37:41', 1),
(2, 'inovacao', NULL, 'inovacao@email.com.br', '81dc9bdb52d04dc20036dbd8313ed055', 'N', '2019-11-15 22:37:41', 3),
(3, 'colaborador', NULL, 'colaborador@email.com.br', '81dc9bdb52d04dc20036dbd8313ed055', 'N', '2019-11-15 22:37:41', 4),
(4, 'revisao', NULL, 'revisao@email.com.br', '81dc9bdb52d04dc20036dbd8313ed055', 'N', '2019-11-15 22:37:41', 2),
(5, 'patrocinador', NULL, 'patrocinador@email.com.br', '81dc9bdb52d04dc20036dbd8313ed055', 'N', '2019-11-15 22:37:41', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DOCUMENTO_AVALIACAO`
--
ALTER TABLE `DOCUMENTO_AVALIACAO`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `COD_TIPO` (`COD_TIPO`),
  ADD KEY `COD_JUSTIFICATIVA` (`COD_JUSTIFICATIVA`),
  ADD KEY `COD_USUARIO` (`COD_USUARIO`),
  ADD KEY `COD_IDEIA` (`COD_IDEIA`);

--
-- Indexes for table `ESTADO`
--
ALTER TABLE `ESTADO`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indexes for table `IDEIA`
--
ALTER TABLE `IDEIA`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `COD_USUARIO` (`COD_USUARIO`),
  ADD KEY `COD_ESTADO` (`COD_ESTADO`);

--
-- Indexes for table `JUSTIFICATIVA`
--
ALTER TABLE `JUSTIFICATIVA`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indexes for table `PAPEL`
--
ALTER TABLE `PAPEL`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `TIPO`
--
ALTER TABLE `TIPO`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indexes for table `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `COD_PAPEL` (`COD_PAPEL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DOCUMENTO_AVALIACAO`
--
ALTER TABLE `DOCUMENTO_AVALIACAO`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `IDEIA`
--
ALTER TABLE `IDEIA`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `USUARIO`
--
ALTER TABLE `USUARIO`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `DOCUMENTO_AVALIACAO`
--
ALTER TABLE `DOCUMENTO_AVALIACAO`
  ADD CONSTRAINT `DOCUMENTO_AVALIACAO_ibfk_1` FOREIGN KEY (`COD_TIPO`) REFERENCES `TIPO` (`CODIGO`),
  ADD CONSTRAINT `DOCUMENTO_AVALIACAO_ibfk_2` FOREIGN KEY (`COD_JUSTIFICATIVA`) REFERENCES `JUSTIFICATIVA` (`CODIGO`),
  ADD CONSTRAINT `DOCUMENTO_AVALIACAO_ibfk_3` FOREIGN KEY (`COD_USUARIO`) REFERENCES `USUARIO` (`ID`),
  ADD CONSTRAINT `DOCUMENTO_AVALIACAO_ibfk_4` FOREIGN KEY (`COD_IDEIA`) REFERENCES `IDEIA` (`ID`);

--
-- Constraints for table `IDEIA`
--
ALTER TABLE `IDEIA`
  ADD CONSTRAINT `IDEIA_ibfk_1` FOREIGN KEY (`COD_USUARIO`) REFERENCES `USUARIO` (`ID`),
  ADD CONSTRAINT `IDEIA_ibfk_2` FOREIGN KEY (`COD_ESTADO`) REFERENCES `ESTADO` (`CODIGO`);

--
-- Constraints for table `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD CONSTRAINT `USUARIO_ibfk_1` FOREIGN KEY (`COD_PAPEL`) REFERENCES `PAPEL` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
