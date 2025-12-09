-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 09/12/2025 às 23:24
-- Versão do servidor: 8.4.7
-- Versão do PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ouvidoria`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `manifestacoes`
--

DROP TABLE IF EXISTS `manifestacoes`;
CREATE TABLE IF NOT EXISTS `manifestacoes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `protocolo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_manifestacao_id` bigint UNSIGNED NOT NULL,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sigilo_dados` tinyint(1) NOT NULL DEFAULT '0',
  `assunto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ABERTO','EM_ANALISE','RESPONDIDO','FINALIZADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ABERTO',
  `canal` enum('WEB','EMAIL','TELEFONE','PRESENCIAL','WHATSAPP') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WEB',
  `anexo_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resposta` text COLLATE utf8mb4_unicode_ci,
  `respondido_em` timestamp NULL DEFAULT NULL,
  `data_limite_resposta` date DEFAULT NULL,
  `observacao_interna` text COLLATE utf8mb4_unicode_ci,
  `arquivado_em` timestamp NULL DEFAULT NULL,
  `motivo_arquivamento` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `data_entrada` timestamp NULL DEFAULT NULL,
  `data_registro_sistema` timestamp NULL DEFAULT NULL,
  `data_resposta` date DEFAULT NULL,
  `prioridade` enum('baixa','media','alta','urgente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'media',
  `setor_responsavel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `manifestacoes_protocolo_unique` (`protocolo`),
  KEY `manifestacoes_user_id_foreign` (`user_id`),
  KEY `manifestacoes_tipo_manifestacao_id_foreign` (`tipo_manifestacao_id`),
  KEY `manifestacoes_protocolo_index` (`protocolo`),
  KEY `manifestacoes_status_index` (`status`),
  KEY `manifestacoes_created_at_index` (`created_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_12_06_234608_create_tipos_manifestacao_table', 1),
(3, '2025_12_06_234626_create_manifestacoes_table', 1),
(4, '2025_12_06_234636_create_users_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos_manifestacao`
--

DROP TABLE IF EXISTS `tipos_manifestacao`;
CREATE TABLE IF NOT EXISTS `tipos_manifestacao` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cor` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#007bff',
  `prazo_dias` int NOT NULL DEFAULT '30',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tipos_manifestacao`
--

INSERT INTO `tipos_manifestacao` (`id`, `nome`, `cor`, `prazo_dias`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Reclamação', '#dc3545', 30, 1, '2025-12-09 23:12:05', '2025-12-09 23:12:05'),
(2, 'Elogio', '#28a745', 15, 1, '2025-12-09 23:12:05', '2025-12-09 23:12:05'),
(3, 'Sugestão', '#17a2b8', 20, 1, '2025-12-09 23:12:05', '2025-12-09 23:12:05'),
(4, 'Denúncia', '#ffc107', 30, 1, '2025-12-09 23:12:05', '2025-12-09 23:12:05'),
(5, 'Solicitação de Informação', '#6f42c1', 20, 1, '2025-12-09 23:12:05', '2025-12-09 23:12:05'),
(6, 'Outros', '#a3b18a', 30, 1, '2025-12-09 23:12:05', '2025-12-09 23:12:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','ouvidor','secretario') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'secretario',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `ativo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador FASPM', 'admin@faspmpa.com.br', NULL, '$2y$12$k8h51G5VJ2ENEg7bM/L4JeggIGd3aPMxSukE5XlWVhYbqH2SDK9dO', 'admin', 1, NULL, '2025-12-09 23:12:06', '2025-12-09 23:12:06'),
(2, 'Ouvidor FASPM', 'ouvidor@faspmpa.com.br', NULL, '$2y$12$wiraR1GGbio7KB11ORyMcegfHdifGzd76lTarst4LNsY5H.1qrtSS', 'ouvidor', 1, NULL, '2025-12-09 23:12:06', '2025-12-09 23:12:06'),
(3, 'Secretário FASPM', 'secretario@faspmpa.com.br', NULL, '$2y$12$C5eIQixM/VewdZb5T9rI3eTBr88r4Vl.QSZoW3mxM4qDb41ZI6w8G', 'secretario', 1, NULL, '2025-12-09 23:12:07', '2025-12-09 23:12:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
