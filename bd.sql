-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.21 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para angularnoticiasv1
DROP DATABASE IF EXISTS `angularnoticiasv1`;
CREATE DATABASE IF NOT EXISTS `angularnoticiasv1` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `angularnoticiasv1`;


-- Copiando estrutura para tabela angularnoticiasv1.filial
DROP TABLE IF EXISTS `filial`;
CREATE TABLE IF NOT EXISTS `filial` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.filial: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `filial` DISABLE KEYS */;
INSERT INTO `filial` (`id`, `descricao`) VALUES
	(1, 'NOME FILIALA 01 EDITADO');
/*!40000 ALTER TABLE `filial` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.imagem
DROP TABLE IF EXISTS `imagem`;
CREATE TABLE IF NOT EXISTS `imagem` (
  `idimagem` int(11) NOT NULL AUTO_INCREMENT,
  `imagemtitulo` varchar(160) NOT NULL,
  `imagemarquivo` varchar(100) NOT NULL,
  `noticia_idnoticia` int(11) NOT NULL,
  PRIMARY KEY (`idimagem`),
  KEY `fk_imagem_noticia_idx` (`noticia_idnoticia`),
  CONSTRAINT `fk_imagem_noticia` FOREIGN KEY (`noticia_idnoticia`) REFERENCES `noticia` (`idnoticia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.imagem: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `imagem` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagem` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.noticia
DROP TABLE IF EXISTS `noticia`;
CREATE TABLE IF NOT EXISTS `noticia` (
  `idnoticia` int(11) NOT NULL AUTO_INCREMENT,
  `noticiatitulo` varchar(200) NOT NULL,
  `noticiadescricao` varchar(250) DEFAULT NULL,
  `noticiatexto` text,
  `noticiadata` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noticiastatus` int(11) NOT NULL DEFAULT '1' COMMENT '1 = bloqueado\n2 = desbloqueado',
  PRIMARY KEY (`idnoticia`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.noticia: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `noticia` DISABLE KEYS */;
INSERT INTO `noticia` (`idnoticia`, `noticiatitulo`, `noticiadescricao`, `noticiatexto`, `noticiadata`, `noticiastatus`) VALUES
	(13, 'a', 'b', '222222', '0000-00-00 00:00:00', 1),
	(14, 'aaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaa', '111111111', '0000-00-00 00:00:00', 1),
	(15, 'aaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaa', '0000-00-00 00:00:00', 1),
	(16, 'asdas', 'dasd', 'asdaasdassd', '0000-00-00 00:00:00', 1),
	(17, 'asdas', 'dasda', '123123', '2015-10-13 10:46:25', 1),
	(18, 'asdas', 'dasd', 'asdasd', '2015-10-13 10:47:57', 1),
	(19, 'asdas', 'dasd', 'asdasd', '2015-10-13 10:48:23', 1),
	(20, 'asdasd', 'asdas', '131231232', '2015-10-13 10:48:44', 1),
	(21, 'nova noticia', 'breve descricao', '1231323', '2016-09-09 00:00:00', 1),
	(22, 'aa', 'a', 'asd', '2015-12-25 00:00:00', 1),
	(23, '123456asd', '12332', '123324', '2016-11-17 00:00:00', 1),
	(24, 'aa', 'a', 'asd', '2015-12-25 00:00:00', 1),
	(25, '123', '123567', 'minha', '2016-11-12 00:00:00', 1),
	(26, '123', '123', '13123132', '2015-10-13 11:59:41', 1);
/*!40000 ALTER TABLE `noticia` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.perfilusuario
DROP TABLE IF EXISTS `perfilusuario`;
CREATE TABLE IF NOT EXISTS `perfilusuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.perfilusuario: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `perfilusuario` DISABLE KEYS */;
INSERT INTO `perfilusuario` (`id`, `descricao`) VALUES
	(1, 'Acesso Completo');
/*!40000 ALTER TABLE `perfilusuario` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.supervisor
DROP TABLE IF EXISTS `supervisor`;
CREATE TABLE IF NOT EXISTS `supervisor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.supervisor: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `supervisor` DISABLE KEYS */;
INSERT INTO `supervisor` (`id`, `descricao`) VALUES
	(1, 'supervisor 1 editado');
/*!40000 ALTER TABLE `supervisor` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.tipoagencia
DROP TABLE IF EXISTS `tipoagencia`;
CREATE TABLE IF NOT EXISTS `tipoagencia` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.tipoagencia: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tipoagencia` DISABLE KEYS */;
INSERT INTO `tipoagencia` (`id`, `descricao`) VALUES
	(2, 'tipo agencia'),
	(3, 'tipo agencia 3');
/*!40000 ALTER TABLE `tipoagencia` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.tipodocumento
DROP TABLE IF EXISTS `tipodocumento`;
CREATE TABLE IF NOT EXISTS `tipodocumento` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.tipodocumento: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `tipodocumento` DISABLE KEYS */;
INSERT INTO `tipodocumento` (`id`, `descricao`) VALUES
	(2, 'tipo documento teste');
/*!40000 ALTER TABLE `tipodocumento` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.tiposituacaocontrato
DROP TABLE IF EXISTS `tiposituacaocontrato`;
CREATE TABLE IF NOT EXISTS `tiposituacaocontrato` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.tiposituacaocontrato: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tiposituacaocontrato` DISABLE KEYS */;
INSERT INTO `tiposituacaocontrato` (`id`, `descricao`) VALUES
	(1, 'situacao de contrato'),
	(2, 'tipo situacao');
/*!40000 ALTER TABLE `tiposituacaocontrato` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.tipovenda
DROP TABLE IF EXISTS `tipovenda`;
CREATE TABLE IF NOT EXISTS `tipovenda` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.tipovenda: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `tipovenda` DISABLE KEYS */;
INSERT INTO `tipovenda` (`id`, `descricao`) VALUES
	(1, 'tipo venda 01 editado');
/*!40000 ALTER TABLE `tipovenda` ENABLE KEYS */;


-- Copiando estrutura para tabela angularnoticiasv1.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `idPerfilUsuario` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `FK_Usuario_PerfilUsuario` (`idPerfilUsuario`),
  CONSTRAINT `FK_Usuario_PerfilUsuario` FOREIGN KEY (`idPerfilUsuario`) REFERENCES `perfilusuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela angularnoticiasv1.usuario: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id`, `usuario`, `senha`, `idPerfilUsuario`, `status`) VALUES
	(59, '1', 'c4ca4238a0b923820dcc509a6f75849b', 1, 1),
	(88, 'teste', 'e8d95a51f3af4a3b134bf6bb680a213a', 1, 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
