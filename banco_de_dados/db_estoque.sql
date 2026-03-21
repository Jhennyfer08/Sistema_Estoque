CREATE DATABASE  IF NOT EXISTS `db_estoque` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_estoque`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: db_estoque
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_endereco`
--

DROP TABLE IF EXISTS `tb_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_endereco` (
  `end_id` int unsigned NOT NULL AUTO_INCREMENT,
  `end_cep` char(8) NOT NULL,
  `end_rua` varchar(50) NOT NULL,
  `end_num` varchar(10) DEFAULT NULL,
  `end_bairro` varchar(50) NOT NULL,
  `end_cidade` varchar(50) NOT NULL,
  `end_estado` char(2) DEFAULT NULL,
  PRIMARY KEY (`end_id`),
  CONSTRAINT `chk_estado` CHECK ((`end_estado` in (_utf8mb4'AC',_utf8mb4'AL',_utf8mb4'AP',_utf8mb4'AM',_utf8mb4'BA',_utf8mb4'CE',_utf8mb4'DF',_utf8mb4'ES',_utf8mb4'GO',_utf8mb4'MA',_utf8mb4'MT',_utf8mb4'MS',_utf8mb4'MG',_utf8mb4'PA',_utf8mb4'PB',_utf8mb4'PR',_utf8mb4'PE',_utf8mb4'PI',_utf8mb4'RJ',_utf8mb4'RN',_utf8mb4'RS',_utf8mb4'RO',_utf8mb4'RR',_utf8mb4'SC',_utf8mb4'SP',_utf8mb4'SE',_utf8mb4'TO')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_endereco`
--

LOCK TABLES `tb_endereco` WRITE;
/*!40000 ALTER TABLE `tb_endereco` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_fornecedor`
--

DROP TABLE IF EXISTS `tb_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_fornecedor` (
  `for_id` int unsigned NOT NULL AUTO_INCREMENT,
  `for_cnpj` varchar(14) NOT NULL,
  `for_nome` varchar(255) NOT NULL,
  `end_id` int unsigned NOT NULL,
  PRIMARY KEY (`for_id`),
  UNIQUE KEY `for_cnpj` (`for_cnpj`),
  KEY `end_id` (`end_id`),
  CONSTRAINT `tb_fornecedor_ibfk_1` FOREIGN KEY (`end_id`) REFERENCES `tb_endereco` (`end_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_fornecedor`
--

LOCK TABLES `tb_fornecedor` WRITE;
/*!40000 ALTER TABLE `tb_fornecedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_funcao`
--

DROP TABLE IF EXISTS `tb_funcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_funcao` (
  `fun_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fun_nome` varchar(45) NOT NULL,
  PRIMARY KEY (`fun_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_funcao`
--

LOCK TABLES `tb_funcao` WRITE;
/*!40000 ALTER TABLE `tb_funcao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_funcao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_log`
--

DROP TABLE IF EXISTS `tb_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_log` (
  `id_log` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_acao` varchar(50) NOT NULL,
  `log_entidade` varchar(50) NOT NULL,
  `log_detalhe` varchar(255) NOT NULL,
  `log_data_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_ip` varchar(45) NOT NULL,
  `log_entidade_id` int unsigned NOT NULL,
  `usu_id` int unsigned NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `usu_id` (`usu_id`),
  CONSTRAINT `tb_log_ibfk_1` FOREIGN KEY (`usu_id`) REFERENCES `tb_usuario` (`usu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_log`
--

LOCK TABLES `tb_log` WRITE;
/*!40000 ALTER TABLE `tb_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_material`
--

DROP TABLE IF EXISTS `tb_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_material` (
  `mat_id` int unsigned NOT NULL AUTO_INCREMENT,
  `mat_codigo` varchar(20) NOT NULL,
  `mat_nome` varchar(255) NOT NULL,
  `mat_quantidade` decimal(8,2) NOT NULL,
  `mat_valor` decimal(8,2) NOT NULL,
  `mat_status` enum('entrada','saida','perdido') NOT NULL,
  `mat_data_cad` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mat_data_altera` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uni_id` int unsigned NOT NULL,
  PRIMARY KEY (`mat_id`),
  UNIQUE KEY `mat_codigo` (`mat_codigo`),
  KEY `uni_id` (`uni_id`),
  CONSTRAINT `tb_material_ibfk_1` FOREIGN KEY (`uni_id`) REFERENCES `tb_unidade_medida` (`uni_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_material`
--

LOCK TABLES `tb_material` WRITE;
/*!40000 ALTER TABLE `tb_material` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_movimentacao`
--

DROP TABLE IF EXISTS `tb_movimentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_movimentacao` (
  `mov_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mov_tipo` enum('entrada','saida','ajuste','devolucao') NOT NULL,
  `mov_quantidade` decimal(10,2) NOT NULL,
  `mov_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mov_observacao` varchar(255) DEFAULT NULL,
  `usu_id` int unsigned NOT NULL,
  `mat_id` int unsigned NOT NULL,
  PRIMARY KEY (`mov_id`),
  KEY `usu_id` (`usu_id`),
  KEY `mat_id` (`mat_id`),
  CONSTRAINT `tb_movimentacao_ibfk_1` FOREIGN KEY (`usu_id`) REFERENCES `tb_usuario` (`usu_id`),
  CONSTRAINT `tb_movimentacao_ibfk_2` FOREIGN KEY (`mat_id`) REFERENCES `tb_material` (`mat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_movimentacao`
--

LOCK TABLES `tb_movimentacao` WRITE;
/*!40000 ALTER TABLE `tb_movimentacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_movimentacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_setor`
--

DROP TABLE IF EXISTS `tb_setor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_setor` (
  `set_id` int unsigned NOT NULL AUTO_INCREMENT,
  `set_nome` varchar(45) NOT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_setor`
--

LOCK TABLES `tb_setor` WRITE;
/*!40000 ALTER TABLE `tb_setor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_setor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_unidade_medida`
--

DROP TABLE IF EXISTS `tb_unidade_medida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_unidade_medida` (
  `uni_id` int unsigned NOT NULL AUTO_INCREMENT,
  `uni_nome` varchar(20) NOT NULL,
  `uni_sigla` varchar(5) NOT NULL,
  PRIMARY KEY (`uni_id`),
  UNIQUE KEY `uni_nome` (`uni_nome`),
  UNIQUE KEY `uni_sigla` (`uni_sigla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_unidade_medida`
--

LOCK TABLES `tb_unidade_medida` WRITE;
/*!40000 ALTER TABLE `tb_unidade_medida` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_unidade_medida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_usuario` (
  `usu_id` int unsigned NOT NULL AUTO_INCREMENT,
  `usu_codigo` int unsigned NOT NULL,
  `usu_cpf` varchar(11) NOT NULL,
  `usu_nome` varchar(200) NOT NULL,
  `usu_data_nasc` date NOT NULL,
  `usu_data_cont` date NOT NULL,
  `usu_email` varchar(75) NOT NULL,
  `usu_login` varchar(45) NOT NULL,
  `usu_senha` varchar(150) NOT NULL,
  `usu_modo` enum('ativo','inativo') NOT NULL,
  `usu_rec_senha` varchar(200) DEFAULT NULL,
  `usu_data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usu_permissao` varchar(20) DEFAULT NULL,
  `end_id` int unsigned NOT NULL,
  `set_id` int unsigned NOT NULL,
  `fun_id` int unsigned NOT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `usu_codigo` (`usu_codigo`),
  UNIQUE KEY `usu_cpf` (`usu_cpf`),
  UNIQUE KEY `usu_login` (`usu_login`),
  UNIQUE KEY `usu_senha` (`usu_senha`),
  KEY `end_id` (`end_id`),
  KEY `set_id` (`set_id`),
  KEY `fun_id` (`fun_id`),
  CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`end_id`) REFERENCES `tb_endereco` (`end_id`),
  CONSTRAINT `tb_usuario_ibfk_2` FOREIGN KEY (`set_id`) REFERENCES `tb_setor` (`set_id`),
  CONSTRAINT `tb_usuario_ibfk_3` FOREIGN KEY (`fun_id`) REFERENCES `tb_funcao` (`fun_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

create table if not exists tb_estoque (
	est_id int unsigned not null auto_increment,
    est_quantidade decimal(8,2),
    usu_id int unsigned not null,
    mat_id int unsigned not null,
    
    primary key (est_id),
    foreign key (usu_id) references tb_usuario(usu_id),
    foreign key (mat_id) references tb_material(mat_id)
);

alter table tb_movimentacao
add mov_status enum('pendente', 'aceito', 'recusado') default 'pendente',
add mov_usuario_destino int;
--
-- Dumping data for table `tb_usuario`
--

LOCK TABLES `tb_usuario` WRITE;
/*!40000 ALTER TABLE `tb_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-15 12:05:57
