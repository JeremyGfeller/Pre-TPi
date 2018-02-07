-- MySQL Workbench Synchronization
-- Generated: 2018-02-07 11:21
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Jeremy.GFELLER

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER SCHEMA `yonik`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci ;

CREATE TABLE IF NOT EXISTS `yonik`.`users` (
  `id_users` INT(11) NOT NULL AUTO_INCREMENT,
  `users_firstName` VARCHAR(45) NULL DEFAULT NULL,
  `users_lastName` VARCHAR(45) NULL DEFAULT NULL,
  `users_role` INT(11) NULL DEFAULT NULL,
  `users_login` VARCHAR(45) NULL DEFAULT NULL,
  `users_password` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id_users`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `yonik`.`article` (
  `id_article` INT(11) NOT NULL AUTO_INCREMENT,
  `article_prix` INT(11) NULL DEFAULT NULL,
  `fk_typeArticle` INT(11) NOT NULL,
  `fk_brand` INT(11) NOT NULL,
  `fk_size` INT(11) NOT NULL,
  `fk_color` INT(11) NOT NULL,
  PRIMARY KEY (`id_article`),
  INDEX `fk_article_typeArticle1_idx` (`fk_typeArticle` ASC),
  INDEX `fk_article_brand1_idx` (`fk_brand` ASC),
  INDEX `fk_article_size1_idx` (`fk_size` ASC),
  INDEX `fk_article_color1_idx` (`fk_color` ASC),
  CONSTRAINT `fk_article_typeArticle1`
    FOREIGN KEY (`fk_typeArticle`)
    REFERENCES `yonik`.`typeArticle` (`id_typeArticle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_brand1`
    FOREIGN KEY (`fk_brand`)
    REFERENCES `yonik`.`brand` (`id_brand`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_size1`
    FOREIGN KEY (`fk_size`)
    REFERENCES `yonik`.`size` (`id_size`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_color1`
    FOREIGN KEY (`fk_color`)
    REFERENCES `yonik`.`color` (`id_color`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = '	';

CREATE TABLE IF NOT EXISTS `yonik`.`basket` (
  `id_basket` INT(11) NOT NULL AUTO_INCREMENT,
  `fk_article` INT(11) NOT NULL,
  `fk_users` INT(11) NOT NULL,
  PRIMARY KEY (`id_basket`),
  INDEX `fk_article_has_users_users1_idx` (`fk_users` ASC),
  INDEX `fk_article_has_users_article_idx` (`fk_article` ASC),
  CONSTRAINT `fk_article_has_users_article`
    FOREIGN KEY (`fk_article`)
    REFERENCES `yonik`.`article` (`id_article`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_has_users_users1`
    FOREIGN KEY (`fk_users`)
    REFERENCES `yonik`.`users` (`id_users`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `yonik`.`typeArticle` (
  `id_typeArticle` INT(11) NOT NULL AUTO_INCREMENT,
  `typeArticle` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id_typeArticle`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `yonik`.`brand` (
  `id_brand` INT(11) NOT NULL AUTO_INCREMENT,
  `brand` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id_brand`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `yonik`.`size` (
  `id_size` INT(11) NOT NULL AUTO_INCREMENT,
  `size` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id_size`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `yonik`.`color` (
  `id_color` INT(11) NOT NULL AUTO_INCREMENT,
  `color` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id_color`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
