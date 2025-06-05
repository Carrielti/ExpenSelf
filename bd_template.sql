START TRANSACTION;

CREATE DATABASE IF NOT EXISTS bd_expenself;
USE bd_expenself;

-- Tabela: niveis
CREATE TABLE `niveis` (
    `id_nivel` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_nivel`)
);

-- Tabela: usuario
CREATE TABLE `usuario` (
    `id_usuario` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `id_nivel` INT NOT NULL,
    PRIMARY KEY (`id_usuario`),
    FOREIGN KEY (`id_nivel`) REFERENCES `niveis` (`id_nivel`)
        ON UPDATE NO ACTION ON DELETE NO ACTION
);

-- Tabela: despesas
CREATE TABLE `despesas` (
    `id_despesa` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `valor` DECIMAL(10,2) NOT NULL,
    `id_usuario` INT NOT NULL,
    PRIMARY KEY (`id_despesa`),
    FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
        ON UPDATE NO ACTION ON DELETE CASCADE
);

-- Inserindo dados exemplo
INSERT INTO `niveis` (`id_nivel`, `nome`) VALUES
(1, 'Administrador');

COMMIT;

