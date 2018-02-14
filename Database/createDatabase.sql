-- MySQL Workbench Synchronization
-- Generated: 2018-02-07 11:21
-- Model: New Model
-- Version: 1.0
-- Project: Yonik
-- Author: Jeremy.GFELLER

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema yonik
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS yonik;
CREATE SCHEMA IF NOT EXISTS yonik DEFAULT CHARACTER SET utf8 ;
USE yonik ;

-- -----------------------------------------------------
-- Table brand
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS brand (
  id_brand INT(11) NOT NULL AUTO_INCREMENT,
  brand VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_brand))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table typearticle
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS typearticle (
  id_typeArticle INT(11) NOT NULL AUTO_INCREMENT,
  typeArticle VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_typeArticle))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table article
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS article (
  id_article INT(11) NOT NULL AUTO_INCREMENT,
  article_name VARCHAR(45) NULL DEFAULT NULL,
  article_prix INT(11) NULL DEFAULT NULL,
  fk_typeArticle INT(11) NOT NULL,
  fk_brand INT(11) NOT NULL,
  PRIMARY KEY (id_article),
  INDEX fk_article_typeArticle1_idx (fk_typeArticle ASC),
  INDEX fk_article_brand1_idx (fk_brand ASC),
  CONSTRAINT fk_article_brand1
    FOREIGN KEY (fk_brand)
    REFERENCES brand (id_brand)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_article_typeArticle1
    FOREIGN KEY (fk_typeArticle)
    REFERENCES typearticle (id_typeArticle)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = '	';

-- -----------------------------------------------------
-- Table users
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id_users INT(11) NOT NULL AUTO_INCREMENT,
  users_firstName VARCHAR(45) NULL DEFAULT NULL,
  users_lastName VARCHAR(45) NULL DEFAULT NULL,
  users_role INT(11) NULL DEFAULT NULL,
  users_login VARCHAR(45) NULL DEFAULT NULL,
  users_password VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_users))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table size
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS size (
  id_size INT(11) NOT NULL AUTO_INCREMENT,
  size INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (id_size))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table color
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS color (
  id_color INT(11) NOT NULL AUTO_INCREMENT,
  color VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (id_color))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table stock
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS stock (
  id_stock INT(11) NOT NULL AUTO_INCREMENT,
  quantity INT(11) NOT NULL DEFAULT '0',
  illustration TEXT NULL DEFAULT NULL,
  fk_article INT(11) NOT NULL,
  fk_size INT(11) NOT NULL,
  fk_color INT(11) NOT NULL,
  PRIMARY KEY (id_stock),
  INDEX fk_stock_size_idx (fk_size ASC),
  INDEX fk_stock_color1_idx (fk_color ASC),
  INDEX fk_stock_article1_idx (fk_article ASC),
  CONSTRAINT fk_stock_size
    FOREIGN KEY (fk_size)
    REFERENCES size (id_size)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_stock_color1
    FOREIGN KEY (fk_color)
    REFERENCES color (id_color)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_stock_article1
    FOREIGN KEY (fk_article)
    REFERENCES article (id_article)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table basket
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS basket (
  id_basket INT(11) NOT NULL AUTO_INCREMENT,
  fk_users INT(11) NOT NULL,
  fk_stock INT(11) NOT NULL,
  PRIMARY KEY (id_basket),
  INDEX fk_article_has_users_users1_idx (fk_users ASC),
  INDEX fk_basket_stock1_idx (fk_stock ASC),
  CONSTRAINT fk_article_has_users_users1
    FOREIGN KEY (fk_users)
    REFERENCES users (id_users)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_basket_stock1
    FOREIGN KEY (fk_stock)
    REFERENCES stock (id_stock)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table payment
-- -----------------------------------------------------
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
    REFERENCES basket (id_basket)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO users (users_firstName, users_role, users_login, users_password) VALUES ('admin', '0', 'admin', password('123'));

INSERT INTO brand (brand) VALUES ('Nike');
INSERT INTO brand (brand) VALUES ('Adidas');
INSERT INTO brand (brand) VALUES ('Puma');

INSERT INTO typearticle (typeArticle) VALUES ('Habit');
INSERT INTO typearticle (typeArticle) VALUES ('Chaussure');
INSERT INTO typearticle (typeArticle) VALUES ('Sac à dos');

INSERT INTO article (article_name, article_prix, fk_typeArticle, fk_brand) VALUES ('Blazer', '100', '2', '1');
INSERT INTO article (article_name, article_prix, fk_typeArticle, fk_brand) VALUES ('Gazelle', '90', '2', '2');
INSERT INTO article (article_name, article_prix, fk_typeArticle, fk_brand) VALUES ('Classic', '85', '2', '3');

INSERT INTO color (color) VALUES ('Noir');
INSERT INTO color (color) VALUES ('Blanc');
INSERT INTO color (color) VALUES ('Rouge');
INSERT INTO color (color) VALUES ('Vert');
INSERT INTO color (color) VALUES ('Bleu');

INSERT INTO size (size) VALUES ('36');
INSERT INTO size (size) VALUES ('37');
INSERT INTO size (size) VALUES ('38');
INSERT INTO size (size) VALUES ('39');
INSERT INTO size (size) VALUES ('40');
INSERT INTO size (size) VALUES ('41');
INSERT INTO size (size) VALUES ('42');
INSERT INTO size (size) VALUES ('43');
INSERT INTO size (size) VALUES ('44');
INSERT INTO size (size) VALUES ('45');
INSERT INTO size (size) VALUES ('46');

INSERT INTO stock (quantity, illustration, fk_article, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '1', '1');
INSERT INTO stock (quantity, illustration, fk_article, fk_size, fk_color) VALUES ('5', 'classic-noir.jpg', '3', '1', '1');
/*INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '36', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '37', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '37', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '38', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '38', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '39', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '39', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '40', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '40', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '41', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '41', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '42', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '42', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '43', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '43', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '44', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '44', '2');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '45', '1');
INSERT INTO stock (quantity, fk_article, fk_size, fk_color) VALUES ('5', '1', '45', '2');*/


