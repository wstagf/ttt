CREATE TABLE `usuario` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`usuario` VARCHAR(50) NOT NULL,
	`senha` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `usuario` (`usuario`)
)

INSERT INTO `usuario` (`usuario`, `senha`) VALUES ('thiago', '123');
