-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Ago-2022 às 22:25
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_salario`
--
CREATE DATABASE IF NOT EXISTS `bd_salario` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_salario`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcionario`
--

CREATE TABLE `tb_funcionario` (
  `cod_salario` int(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario_base` double(8,2) NOT NULL,
  `hrs_extra` double(3,2) NOT NULL,
  `n_dependentes` int(3) NOT NULL,
  `salario_bruto` double(8,2) NOT NULL,
  `inss` double(8,2) NOT NULL,
  `ir` double(8,2) NOT NULL,
  `salario_liquido` double(8,2) NOT NULL,
  `vlr_hr_extra` double(8,2) NOT NULL,
  `ativo` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_funcionario`
--

INSERT INTO `tb_funcionario` (`cod_salario`, `nome`, `salario_base`, `hrs_extra`, `n_dependentes`, `salario_bruto`, `inss`, `ir`, `salario_liquido`, `vlr_hr_extra`, `ativo`) VALUES
(1, 'Murilo A. Barion', 1000.00, 9.99, 10, 1550.00, 124.00, 0.00, 1426.00, 10.00, b'1');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD PRIMARY KEY (`cod_salario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  MODIFY `cod_salario` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
