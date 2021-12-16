-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 16-Dez-2021 às 07:58
-- Versão do servidor: 5.7.36
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `testegtrigueiro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `idaval` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validado` tinyint(1) NOT NULL,
  `justificativaaval` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dataaval` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuariofk` int(11) NOT NULL,
  `requisicaofk` int(11) NOT NULL,
  PRIMARY KEY (`idaval`),
  KEY `avaliacaousuario` (`usuariofk`),
  KEY `avaliacaorequisicao` (`requisicaofk`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `avaliacao`
--

INSERT INTO `avaliacao` (`idaval`, `ticket`, `validado`, `justificativaaval`, `dataaval`, `usuariofk`, `requisicaofk`) VALUES
(1, '43253245', 1, 'teste essa é uma justificativa do alaviador,  asnoso hsed hoahswo hsoidhg iphsdoibhiu uhdiuedfhiuofhdeoifhbsidii iufdh iodf oh fd h.', '123123', 1, 48),
(2, '43253245', 1, 'teste essa é uma justificativa do alaviador,  asnoso hsed hoahswo hsoidhg iphsdoibhiu uhdiuedfhiuofhdeoifhbsidii iufdh iodf oh fd h.', '123123', 1, 48);

-- --------------------------------------------------------

--
-- Estrutura da tabela `processo`
--

DROP TABLE IF EXISTS `processo`;
CREATE TABLE IF NOT EXISTS `processo` (
  `idproc` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_fk` int(11) NOT NULL,
  PRIMARY KEY (`idproc`),
  KEY `usuario_fk` (`usuario_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `processo`
--

INSERT INTO `processo` (`idproc`, `numero`, `usuario_fk`) VALUES
(1, '2018101', 1),
(2, '2018102', 1),
(3, '2020101', 2),
(4, '2020102', 2),
(5, '2021101', 2),
(6, '2021102', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao`
--

DROP TABLE IF EXISTS `requisicao`;
CREATE TABLE IF NOT EXISTS `requisicao` (
  `idrequisicao` int(11) NOT NULL AUTO_INCREMENT,
  `avaliado` tinyint(1) NOT NULL,
  `data` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `justificativa` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuariofk` int(11) NOT NULL,
  `processofk` int(11) NOT NULL,
  PRIMARY KEY (`idrequisicao`),
  KEY `usuariorequisicao_fk` (`usuariofk`),
  KEY `processorequisicao_fk` (`processofk`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `requisicao`
--

INSERT INTO `requisicao` (`idrequisicao`, `avaliado`, `data`, `justificativa`, `usuariofk`, `processofk`) VALUES
(47, 0, '15/12/2021 21:58', 'teste x', 1, 1),
(48, 1, '15/12/2021 21:58', 'teste x', 1, 2),
(49, 1, '15/12/2021 22:05', 'teste x2', 1, 1),
(50, 0, '15/12/2021 22:05', 'teste x2', 1, 2),
(51, 0, '16/12/2021 05:28', 'teste x', 1, 1),
(52, 0, '16/12/2021 05:28', 'teste x', 1, 1),
(53, 0, '16/12/2021 05:32', 'aedfsdga', 1, 1),
(54, 0, '16/12/2021 05:33', 'aedfsdga', 1, 1),
(55, 0, '16/12/2021 05:38', 'teste x2', 1, 1),
(56, 0, '16/12/2021 05:41', '123123213', 1, 1),
(57, 0, '16/12/2021 05:53', 'teste y', 1, 1),
(58, 0, '16/12/2021 05:57', 'teste y', 1, 1),
(59, 0, '16/12/2021 05:57', 'teste y', 1, 2),
(60, 0, '16/12/2021 05:58', '234', 2, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rg` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avaliador` tinyint(1) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`iduser`, `nome`, `email`, `rg`, `cpf`, `senha`, `avaliador`) VALUES
(1, 'joao', 'joao@email.com', '123321', '123321', '123321', 1),
(2, 'antonio', 'antonio@email.com', '123123', '123123', NULL, 0);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacaorequisicao` FOREIGN KEY (`requisicaofk`) REFERENCES `requisicao` (`idrequisicao`),
  ADD CONSTRAINT `avaliacaousuario` FOREIGN KEY (`usuariofk`) REFERENCES `usuario` (`iduser`);

--
-- Limitadores para a tabela `processo`
--
ALTER TABLE `processo`
  ADD CONSTRAINT `usuario_fk` FOREIGN KEY (`usuario_fk`) REFERENCES `usuario` (`iduser`);

--
-- Limitadores para a tabela `requisicao`
--
ALTER TABLE `requisicao`
  ADD CONSTRAINT `processorequisicao_fk` FOREIGN KEY (`processofk`) REFERENCES `processo` (`idproc`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
