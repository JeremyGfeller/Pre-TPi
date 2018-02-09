-- MySQL Workbench Synchronization
-- Generated: 2018-02-07 11:21
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Jeremy.GFELLER

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS yonik;
CREATE SCHEMA IF NOT EXISTS yonik DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE yonik;

CREATE TABLE IF NOT EXISTS users (
  id_users INT(11) NOT NULL AUTO_INCREMENT,
  users_firstName VARCHAR(45) NULL DEFAULT NULL,
  users_lastName VARCHAR(45) NULL DEFAULT NULL,
  users_role INT(11) NULL DEFAULT NULL,
  users_login VARCHAR(45) NULL DEFAULT NULL,
  users_password VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_users))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS article (
  id_article INT(11) NOT NULL AUTO_INCREMENT,
  article_prix INT(11) NULL DEFAULT NULL,
  fk_typeArticle INT(11) NOT NULL,
  fk_brand INT(11) NOT NULL,
  fk_size INT(11) NOT NULL,
  fk_color INT(11) NOT NULL,
  PRIMARY KEY (id_article),
  INDEX fk_article_typeArticle1_idx (fk_typeArticle ASC),
  INDEX fk_article_brand1_idx (fk_brand ASC),
  INDEX fk_article_size1_idx (fk_size ASC),
  INDEX fk_article_color1_idx (fk_color ASC),
  CONSTRAINT fk_article_typeArticle1
    FOREIGN KEY (fk_typeArticle)
    REFERENCES typeArticle (id_typeArticle)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_article_brand1
    FOREIGN KEY (fk_brand)
    REFERENCES brand (id_brand)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_article_size1
    FOREIGN KEY (fk_size)
    REFERENCES size (id_size)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_article_color1
    FOREIGN KEY (fk_color)
    REFERENCES color (id_color)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = '	';

CREATE TABLE IF NOT EXISTS basket (
  id_basket INT(11) NOT NULL AUTO_INCREMENT,
  fk_article INT(11) NOT NULL,
  fk_users INT(11) NOT NULL,
  PRIMARY KEY (id_basket),
  INDEX fk_article_has_users_users1_idx (fk_users ASC),
  INDEX fk_article_has_users_article_idx (fk_article ASC),
  CONSTRAINT fk_article_has_users_article
    FOREIGN KEY (fk_article)
    REFERENCES article (id_article)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_article_has_users_users1
    FOREIGN KEY (fk_users)
    REFERENCES users (id_users)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS typeArticle (
  id_typeArticle INT(11) NOT NULL AUTO_INCREMENT,
  typeArticle VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_typeArticle))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS brand (
  id_brand INT(11) NOT NULL AUTO_INCREMENT,
  brand VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_brand))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS size (
  id_size INT(11) NOT NULL AUTO_INCREMENT,
  size INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (id_size))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS color (
  id_color INT(11) NOT NULL AUTO_INCREMENT,
  color VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_color))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS payment (
  id_payment INT(11) NOT NULL AUTO_INCREMENT,
  payment_date DATE NULL DEFAULT NULL,
  payment_bill INT(11) NULL DEFAULT NULL,
  payment_status VARCHAR(45) NULL DEFAULT NULL,
  fk_basket INT(11) NOT NULL,
  PRIMARY KEY (id_payment),
  INDEX fk_payment_basket1_idx (fk_basket ASC),
  CONSTRAINT fk_payment_basket1
    FOREIGN KEY (fk_basket)
    REFERENCES yonik.basket (id_basket)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO users (users_firstName, users_role, users_login, users_password) VALUES ('admin', '0', 'admin', password('123'));
