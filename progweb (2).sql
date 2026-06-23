-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Out-2020 às 20:08
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progweb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `cli_cpf` varchar(11) NOT NULL,
  `cli_nome` varchar(100) NOT NULL,
  `cli_end_lograd` varchar(200) NOT NULL,
  `cli_end_compl` varchar(50) NOT NULL,
  `cli_end_bairro` varchar(50) NOT NULL,
  `cli_end_cidade` varchar(50) NOT NULL,
  `cli_end_uf` varchar(2) NOT NULL,
  `cli_end_pais` varchar(50) NOT NULL,
  `cli_login` varchar(30) NOT NULL,
  `cli_senha` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`cli_cpf`, `cli_nome`, `cli_end_lograd`, `cli_end_compl`, `cli_end_bairro`, `cli_end_cidade`, `cli_end_uf`, `cli_end_pais`, `cli_login`, `cli_senha`) VALUES
('08322527608', 'Este Ã© o novo Cli Incluir', '', '', '', '', 'RJ', '', '', '734f68a8ea9a'),
('35725723046', 'Ernesto senha 33', 'Rua do Ernesto 33', '330', 'Bairo Ernesto', 'Cidade Ernesto', 'TO', 'Brasil', 'ernesto@com.br', '182be0c5cdcd'),
('38658677311', '2222222', '2222222222', '2222222222', '2222222', '222222', 'RJ', '2222222', '222222@222222', '22'),
('38970071857', 'Mais um Cliente ', 'EndereÃ§o do mais', '', '', '', 'RJ', '', '', '6512bd43d9ca'),
('40630285772', 'JoÃ£o Quadros Coimbra', '', '', '', '', 'RJ', '', '', 'bf2bc2545a4a'),
('64867023035', '11111111111', '111111', '', '', '', 'RJ', '', '', 'd41d8cd98f00'),
('72203658967', 'Valdomiro da Silva Ramos senha 22', 'EndereÃ§o do Valdomiro 100', '200', 'Bairro do Val', 'Rio Branco', 'AC', 'Brasil', 'val@com.br', '22'),
('81937746631', 'Nome de acentuaÃ§Ã£o', '111111111111111', '111111111111111', '', '', 'PA', '', '', ''),
('85282178508', 'Mais um Cliente', '', '', '', '', 'RJ', '', '', '7164a49d8120');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_quant` int(11) NOT NULL,
  `item_preco` double NOT NULL,
  `item_prod_id` int(11) NOT NULL,
  `item_venda_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`item_id`, `item_quant`, `item_preco`, `item_prod_id`, `item_venda_id`) VALUES
(1, 2, 111.99, 6, 22),
(3, 2, 111, 6, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `prod_id` int(11) NOT NULL,
  `prod_desc` varchar(255) NOT NULL,
  `prod_preco` decimal(20,2) NOT NULL,
  `prod_quant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`prod_id`, `prod_desc`, `prod_preco`, `prod_quant`) VALUES
(1, 'Primeiro xxxxxxxxx', '110.00', 110),
(2, 'Segundo', '200.00', 200),
(3, 'Terceiro este mudou', '300.00', 300),
(4, 'Mais um produto', '100.00', 100),
(6, '111', '111.00', 111),
(7, '222', '222.45', 222),
(8, '55', '55.00', 55),
(9, '66', '66.66', 66),
(10, '88', '88.88', 88),
(11, '99', '100.00', 99),
(12, '999', '999.99', 99),
(13, 'Este Ã© mais um produto', '110.00', 210);

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `venda_id` int(11) NOT NULL,
  `venda_cli_cpf` varchar(11) NOT NULL,
  `venda_data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `venda`
--

INSERT INTO `venda` (`venda_id`, `venda_cli_cpf`, `venda_data`) VALUES
(5, '64867023035', '2020-10-01 00:00:00'),
(6, '64867023035', '2020-10-01 00:00:00'),
(7, '81937746631', '2020-10-01 00:00:00'),
(8, '64867023035', '2020-10-01 00:00:00'),
(9, '64867023035', '2020-10-01 00:00:00'),
(10, '64867023035', '2020-10-01 00:00:00'),
(11, '64867023035', '2020-10-01 00:00:00'),
(12, '64867023035', '2020-10-01 00:00:00'),
(13, '64867023035', '2020-10-02 00:00:00'),
(14, '64867023035', '2020-10-02 00:00:00'),
(15, '64867023035', '2020-10-02 00:00:00'),
(16, '64867023035', '2020-10-02 00:00:00'),
(17, '64867023035', '2020-10-02 00:00:00'),
(18, '64867023035', '2020-10-02 00:00:00'),
(19, '64867023035', '2020-10-02 00:00:00'),
(20, '64867023035', '2020-10-02 00:00:00'),
(21, '64867023035', '2020-10-02 00:00:00'),
(22, '64867023035', '2020-10-02 00:00:00'),
(23, '81937746631', '2020-10-02 00:00:00'),
(24, '81937746631', '2020-10-02 00:00:00'),
(25, '81937746631', '2020-10-02 00:00:00'),
(26, '81937746631', '2020-10-02 00:00:00'),
(27, '81937746631', '2020-10-02 00:00:00'),
(28, '81937746631', '2020-10-02 00:00:00'),
(29, '81937746631', '2020-10-02 00:00:00'),
(30, '81937746631', '2020-10-02 00:00:00'),
(31, '81937746631', '2020-10-02 00:00:00'),
(32, '81937746631', '2020-10-02 00:00:00'),
(33, '81937746631', '2020-10-02 00:00:00'),
(34, '64867023035', '2020-10-02 00:00:00'),
(35, '64867023035', '2020-10-02 02:11:00'),
(36, '64867023035', '2020-10-06 15:24:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cli_cpf`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_produto_fk` (`item_prod_id`),
  ADD KEY `item_venda_id` (`item_venda_id`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`venda_id`),
  ADD KEY `venda_cliente_fk` (`venda_cli_cpf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `venda`
--
ALTER TABLE `venda`
  MODIFY `venda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_produto_fk` FOREIGN KEY (`item_prod_id`) REFERENCES `produto` (`prod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `item_venda_fk` FOREIGN KEY (`item_venda_id`) REFERENCES `venda` (`venda_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_cliente_fk` FOREIGN KEY (`venda_cli_cpf`) REFERENCES `cliente` (`cli_cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
