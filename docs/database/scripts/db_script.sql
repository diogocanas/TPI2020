-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema ETPI
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ETPI
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ETPI` DEFAULT CHARACTER SET utf8 ;
USE `ETPI` ;

-- -----------------------------------------------------
-- Table `ETPI`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ETPI`.`users` (
  `id` INT NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `firstName` VARCHAR(0) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
