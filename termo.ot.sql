SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `termo.ot` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `termo.ot` ;

-- -----------------------------------------------------
-- Table `termo.ot`.`base`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`base` (
  `idbase` INT NOT NULL AUTO_INCREMENT,
  `nombre_base` VARCHAR(45) NULL,
  `minicipio` VARCHAR(45) NULL,
  `departamento` VARCHAR(60) NULL,
  `basecol` VARCHAR(45) NULL,
  PRIMARY KEY (`idbase`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termo.ot`.`ot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`ot` (
  `idot` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `municipio` VARCHAR(60) NULL,
  `fecha_inicio` DATE NULL,
  `fecha_fin` DATE NULL,
  `base_idbase` INT NOT NULL,
  PRIMARY KEY (`idot`),
  UNIQUE INDEX `Nombre_UNIQUE` (`nombre` ASC),
  INDEX `fk_ot_base1_idx` (`base_idbase` ASC),
  CONSTRAINT `fk_ot_base1`
    FOREIGN KEY (`base_idbase`)
    REFERENCES `termo.ot`.`base` (`idbase`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termo.ot`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`item` (
  `iditem` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NULL,
  `descripcion` VARCHAR(150) NULL,
  `fecha_agregado` DATE NULL,
  `estado` TINYINT(1) NULL,
  `unidad` VARCHAR(45) NULL,
  PRIMARY KEY (`iditem`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termo.ot`.`tarifa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`tarifa` (
  `idtarifa` INT NOT NULL AUTO_INCREMENT,
  `valor` DOUBLE NULL,
  `fecha_creacion` DATE NULL,
  `fecha_incio` DATE NULL,
  PRIMARY KEY (`idtarifa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termo.ot`.`tarifa_has_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`tarifa_has_item` (
  `idtarifa_has_item` INT NOT NULL AUTO_INCREMENT,
  `tarifa_idtarifa` INT NOT NULL,
  `item_iditem` INT NOT NULL,
  INDEX `fk_tarifa_has_item_item1_idx` (`item_iditem` ASC),
  INDEX `fk_tarifa_has_item_tarifa1_idx` (`tarifa_idtarifa` ASC),
  PRIMARY KEY (`idtarifa_has_item`),
  CONSTRAINT `fk_tarifa_has_item_tarifa1`
    FOREIGN KEY (`tarifa_idtarifa`)
    REFERENCES `termo.ot`.`tarifa` (`idtarifa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tarifa_has_item_item1`
    FOREIGN KEY (`item_iditem`)
    REFERENCES `termo.ot`.`item` (`iditem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termo.ot`.`ot_has_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`ot_has_item` (
  `idot_has_item` INT NOT NULL AUTO_INCREMENT,
  `ot_idot` INT NOT NULL,
  `item_iditem` INT NOT NULL,
  `tiempo` VARCHAR(45) NULL,
  `unidad_tiempo` VARCHAR(45) NULL,
  INDEX `fk_ot_has_item_item1_idx` (`item_iditem` ASC),
  INDEX `fk_ot_has_item_ot1_idx` (`ot_idot` ASC),
  PRIMARY KEY (`idot_has_item`),
  CONSTRAINT `fk_ot_has_item_ot1`
    FOREIGN KEY (`ot_idot`)
    REFERENCES `termo.ot`.`ot` (`idot`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ot_has_item_item1`
    FOREIGN KEY (`item_iditem`)
    REFERENCES `termo.ot`.`item` (`iditem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termo.ot`.`concepto_ot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`concepto_ot` (
  `idconcepto_ot` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NULL,
  `tipo` VARCHAR(45) NULL,
  `codigo_tipo` INT NOT NULL,
  `porcentaje` FLOAT NULL,
  PRIMARY KEY (`idconcepto_ot`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termo.ot`.`concepto_ot_has_ot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termo.ot`.`concepto_ot_has_ot` (
  `idconcepto_ot_has_ot` INT NOT NULL AUTO_INCREMENT,
  `concepto_ot_idconcepto_ot` INT NOT NULL,
  `ot_idot` INT NOT NULL,
  `valor` DOUBLE NULL,
  INDEX `fk_concepto_ot_has_ot_ot1_idx` (`ot_idot` ASC),
  INDEX `fk_concepto_ot_has_ot_concepto_ot1_idx` (`concepto_ot_idconcepto_ot` ASC),
  PRIMARY KEY (`idconcepto_ot_has_ot`),
  CONSTRAINT `fk_concepto_ot_has_ot_concepto_ot1`
    FOREIGN KEY (`concepto_ot_idconcepto_ot`)
    REFERENCES `termo.ot`.`concepto_ot` (`idconcepto_ot`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_concepto_ot_has_ot_ot1`
    FOREIGN KEY (`ot_idot`)
    REFERENCES `termo.ot`.`ot` (`idot`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
