-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/09/2024 às 19:28
-- Versão do servidor: 8.0.35
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `store_management-v2`
--
CREATE DATABASE IF NOT EXISTS `store_management-v2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `store_management-v2`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `uuid` varchar(255) NOT NULL,
  `id` int DEFAULT NULL,
  `id_loja` int DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `id_usuario_modificacao` int DEFAULT NULL,
  `id_usuario_cadastro` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Acionadores `categorias`
--
DELIMITER $$
CREATE TRIGGER `before_insert_categoria` BEFORE INSERT ON `categorias` FOR EACH ROW BEGIN
    DECLARE last_id INT;

    SELECT COALESCE(MAX(id), 0) INTO last_id
    FROM categorias
    WHERE id_loja = NEW.id_loja;

    SET NEW.id = last_id + 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `classificacao_cliente`
--

CREATE TABLE `classificacao_cliente` (
  `uuid` varchar(255) NOT NULL,
  `id` int DEFAULT NULL,
  `id_loja` int DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `regra_limite` varchar(10) DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_modificao` timestamp NULL DEFAULT NULL,
  `id_usuario_cadastro` int DEFAULT NULL,
  `id_usuario_modificacao` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `uuid` varchar(255) NOT NULL,
  `id` int DEFAULT NULL,
  `id_loja` int DEFAULT NULL,
  `nome_razao` varchar(255) DEFAULT NULL,
  `nome_fantasia` varchar(255) DEFAULT NULL,
  `rg_ie` varchar(20) DEFAULT NULL,
  `cpf_cnpj` varchar(20) DEFAULT NULL,
  `tipo_contribuinte` int DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `obs_pedidos` varchar(255) DEFAULT NULL,
  `obs_interna` varchar(255) DEFAULT NULL,
  `id_tabela_preco` varchar(255) DEFAULT NULL,
  `id_classificacao` varchar(255) DEFAULT NULL,
  `eh_cliente` tinyint(1) DEFAULT NULL,
  `eh_fornecedor` tinyint(1) DEFAULT NULL,
  `eh_transportadora` tinyint(1) DEFAULT NULL,
  `eh_funcionario` tinyint(1) DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(255) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `nome_fone` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `id_usuario_cadastro` int DEFAULT NULL,
  `id_usuario_modificacao` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `loja`
--

CREATE TABLE `loja` (
  `uuid` varchar(255) DEFAULT NULL,
  `id` int NOT NULL,
  `nome_razao` varchar(255) DEFAULT NULL,
  `nome_fantasia` varchar(255) DEFAULT NULL,
  `rg_ie` varchar(20) DEFAULT NULL,
  `cpf_cnpj` varchar(14) DEFAULT NULL,
  `tipo_contribuinte` varchar(3) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `id_usuario_cadastro` int DEFAULT NULL,
  `id_usuario_modificacao` int DEFAULT NULL,
  `logotipo` longblob,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(255) DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `uuid` varchar(255) NOT NULL,
  `id` int DEFAULT NULL,
  `id_loja` int DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `id_categoria` varchar(255) DEFAULT NULL,
  `id_un_compra` varchar(255) DEFAULT NULL,
  `id_un_venda` varchar(255) DEFAULT NULL,
  `fator_conversao` double DEFAULT NULL,
  `preco_compra` double DEFAULT NULL,
  `markup_preco_venda` double DEFAULT NULL,
  `preco_venda` double DEFAULT NULL,
  `qtd_estoque` decimal(10,3) NOT NULL DEFAULT '0.000',
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `id_fornecedor` varchar(255) DEFAULT NULL,
  `tipo_produto` int DEFAULT NULL,
  `ncm` varchar(10) DEFAULT NULL,
  `cst_icms` varchar(3) DEFAULT NULL,
  `origem_produto` varchar(3) DEFAULT NULL,
  `cest` varchar(10) DEFAULT NULL,
  `imagem_principal` blob,
  `situacao` tinyint(1) DEFAULT NULL,
  `id_usuario_modificacao` varchar(255) DEFAULT NULL,
  `id_usuario_cadastro` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Acionadores `produtos`
--
DELIMITER $$
CREATE TRIGGER `before_insert_produto` BEFORE INSERT ON `produtos` FOR EACH ROW BEGIN
    DECLARE last_id INT;

    SELECT COALESCE(MAX(id), 0) INTO last_id
    FROM produto
    WHERE id_loja = NEW.id_loja;

    SET NEW.id = last_id + 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_preco`
--

CREATE TABLE `tabela_preco` (
  `uuid` varchar(255) NOT NULL,
  `id` int DEFAULT NULL,
  `id_loja` int DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `tipo_calculo` varchar(10) DEFAULT NULL,
  `percentual` double DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `id_usuario_cadastro` int DEFAULT NULL,
  `id_usuario_modificacao` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `unidade_medida`
--

CREATE TABLE `unidade_medida` (
  `uuid` varchar(255) NOT NULL,
  `id` int DEFAULT NULL,
  `id_loja` int DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `fracionavel` tinyint(1) DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `id_usuario_modificacao` int DEFAULT NULL,
  `id_usuario_cadastro` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `uuid` varchar(255) NOT NULL,
  `id` int DEFAULT NULL,
  `id_loja` int DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT NULL,
  `data_modificacao` timestamp NULL DEFAULT NULL,
  `data_ult_acesso` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UC_CATEGORIAS_ID_LOJA` (`id`,`id_loja`),
  ADD UNIQUE KEY `UC_CATEGORIAS_NOME` (`nome`),
  ADD KEY `FK_CATEGORIA_ID_LOJA` (`id_loja`);

--
-- Índices de tabela `classificacao_cliente`
--
ALTER TABLE `classificacao_cliente`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UC_CLASSIF_ID_LOJA` (`id`,`id_loja`),
  ADD KEY `FK_CLASSIFICAO_ID_LOJA` (`id_loja`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UC_CLIENTES_ID_LOJA` (`id`,`id_loja`),
  ADD UNIQUE KEY `UC_CLIENTES_DOC` (`cpf_cnpj`,`id_loja`),
  ADD UNIQUE KEY `UC_CLIENTES_EMAIL` (`id_loja`,`email`),
  ADD KEY `FK_CLIENTE_TABELA` (`id_tabela_preco`),
  ADD KEY `FK_CLIENTE_CLASSIFICACAO` (`id_classificacao`);

--
-- Índices de tabela `loja`
--
ALTER TABLE `loja`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UC_PRODUTO_ID_LOJA` (`id`,`id_loja`),
  ADD KEY `FK_PRODUTO_ID_LOJA` (`id_loja`),
  ADD KEY `FK_PRODUTO_ID_CATEGORIA` (`id_categoria`),
  ADD KEY `FK_PRODUTO_ID_UN_COMPRA` (`id_un_compra`),
  ADD KEY `FK_PRODUTO_ID_UN_VENDA` (`id_un_venda`),
  ADD KEY `FK_PRODUTO_ID_FORNECEDOR` (`id_fornecedor`),
  ADD KEY `FK_PRODUTO_MODIFICADO` (`id_usuario_modificacao`),
  ADD KEY `FK_PRODUTO_CRIACAO` (`id_usuario_cadastro`);

--
-- Índices de tabela `tabela_preco`
--
ALTER TABLE `tabela_preco`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UC_TABELA_ID_LOJA` (`id`,`id_loja`),
  ADD KEY `FK_TABELA_PRECO_ID_LOJA` (`id_loja`);

--
-- Índices de tabela `unidade_medida`
--
ALTER TABLE `unidade_medida`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UC_UNIDADE_ID_LOJA` (`id`,`id_loja`),
  ADD UNIQUE KEY `UC_UNIDADE_NOME` (`nome`),
  ADD KEY `FK_UNIDADE_ID_LOJA` (`id_loja`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UC_USUARIOS_ID_LOJA` (`id`,`id_loja`),
  ADD UNIQUE KEY `UC_USUARIOS_EMAIL` (`email`),
  ADD UNIQUE KEY `UC_USUARIOS_USER` (`usuario`),
  ADD KEY `FK_USUARIO_ID_LOJA` (`id_loja`);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `FK_CATEGORIA_ID_LOJA` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`);

--
-- Restrições para tabelas `classificacao_cliente`
--
ALTER TABLE `classificacao_cliente`
  ADD CONSTRAINT `FK_CLASSIFICAO_ID_LOJA` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`);

--
-- Restrições para tabelas `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `FK_CLIENTE_CLASSIFICACAO` FOREIGN KEY (`id_classificacao`) REFERENCES `classificacao_cliente` (`uuid`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_CLIENTE_LOJA` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CLIENTE_TABELA` FOREIGN KEY (`id_tabela_preco`) REFERENCES `tabela_preco` (`uuid`) ON DELETE SET NULL;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `FK_PRODUTO_CRIACAO` FOREIGN KEY (`id_usuario_cadastro`) REFERENCES `usuarios` (`uuid`),
  ADD CONSTRAINT `FK_PRODUTO_ID_CATEGORIA` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`uuid`),
  ADD CONSTRAINT `FK_PRODUTO_ID_FORNECEDOR` FOREIGN KEY (`id_fornecedor`) REFERENCES `clientes` (`uuid`),
  ADD CONSTRAINT `FK_PRODUTO_ID_LOJA` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`),
  ADD CONSTRAINT `FK_PRODUTO_ID_UN_COMPRA` FOREIGN KEY (`id_un_compra`) REFERENCES `unidade_medida` (`uuid`),
  ADD CONSTRAINT `FK_PRODUTO_ID_UN_VENDA` FOREIGN KEY (`id_un_venda`) REFERENCES `unidade_medida` (`uuid`),
  ADD CONSTRAINT `FK_PRODUTO_MODIFICADO` FOREIGN KEY (`id_usuario_modificacao`) REFERENCES `usuarios` (`uuid`);

--
-- Restrições para tabelas `tabela_preco`
--
ALTER TABLE `tabela_preco`
  ADD CONSTRAINT `FK_TABELA_PRECO_ID_LOJA` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`);

--
-- Restrições para tabelas `unidade_medida`
--
ALTER TABLE `unidade_medida`
  ADD CONSTRAINT `FK_UNIDADE_ID_LOJA` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_USUARIO_ID_LOJA` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
