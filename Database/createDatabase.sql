-- Version: 1.0
-- Project: Yonik
-- Author: Jeremy GFELLER

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema yonik
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS yonik;
CREATE SCHEMA IF NOT EXISTS yonik DEFAULT CHARACTER SET utf8;
USE yonik;

-- -----------------------------------------------------
-- Table users
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id_users INT(11) NOT NULL AUTO_INCREMENT,
  users_firstName VARCHAR(20) NULL DEFAULT NULL,
  users_lastName VARCHAR(20) NULL DEFAULT NULL,
  users_role INT(11) NULL DEFAULT NULL,
  users_login VARCHAR(30) NULL DEFAULT NULL,
  users_password VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (id_users))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table basket
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS basket (
  id_basket INT(11) NOT NULL AUTO_INCREMENT,
  fk_users INT(11) NOT NULL,
  PRIMARY KEY (id_basket),
  INDEX fk_article_has_users_users1_idx (fk_users ASC),
  CONSTRAINT fk_article_has_users_users1
    FOREIGN KEY (fk_users)
    REFERENCES users (id_users)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table brand
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS brand (
  id_brand INT(11) NOT NULL AUTO_INCREMENT,
  brand VARCHAR(15) NULL DEFAULT NULL,
  PRIMARY KEY (id_brand))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table color
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS color (
  id_color INT(11) NOT NULL AUTO_INCREMENT,
  color VARCHAR(10) NULL,
  PRIMARY KEY (id_color))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table size
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS size (
  id_size INT(11) NOT NULL AUTO_INCREMENT,
  size VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (id_size))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table typearticle
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS typearticle (
  id_typeArticle INT(11) NOT NULL AUTO_INCREMENT,
  typeArticle VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (id_typeArticle))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table model
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS model (
  id_model INT NOT NULL AUTO_INCREMENT,
  model_name VARCHAR(20) NULL,
  model_prix INT(11) NULL DEFAULT NULL,
  fk_typearticle INT(11) NOT NULL,
  fk_brand INT(11) NOT NULL,
  PRIMARY KEY (id_model),
  INDEX fk_model_typearticle1_idx (fk_typearticle ASC),
  INDEX fk_model_brand2_idx (fk_brand ASC),
  CONSTRAINT fk_model_typearticle1
    FOREIGN KEY (fk_typearticle)
    REFERENCES typearticle (id_typeArticle)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_model_brand2
    FOREIGN KEY (fk_brand)
    REFERENCES brand (id_brand)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table article
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS article (
  id_article INT NOT NULL AUTO_INCREMENT,
  quantity INT NOT NULL DEFAULT 0,
  illustration TEXT NULL,
  fk_color INT(11) NOT NULL,
  fk_size INT(11) NOT NULL,
  fk_model INT NOT NULL,
  PRIMARY KEY (id_article),
  INDEX fk_article_color1_idx (fk_color ASC),
  INDEX fk_article_size1_idx (fk_size ASC),
  INDEX fk_article_model1_idx (fk_model ASC),
  CONSTRAINT fk_article_color1
    FOREIGN KEY (fk_color)
    REFERENCES color (id_color)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_article_size1
    FOREIGN KEY (fk_size)
    REFERENCES size (id_size)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_article_model1
    FOREIGN KEY (fk_model)
    REFERENCES model (id_model)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table orderlist
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS orderlist (
  id_orderlist INT NOT NULL AUTO_INCREMENT,
  quantity INT NOT NULL DEFAULT 0,
  fk_article INT NOT NULL,
  fk_basket INT(11) NOT NULL,
  PRIMARY KEY (id_orderlist),
  INDEX fk_orderlist_article1_idx (fk_article ASC),
  INDEX fk_orderlist_basket1_idx (fk_basket ASC),
  CONSTRAINT fk_orderlist_article1
    FOREIGN KEY (fk_article)
    REFERENCES article (id_article)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_orderlist_basket1
    FOREIGN KEY (fk_basket)
    REFERENCES basket (id_basket)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO users (users_firstName, users_role, users_login, users_password) VALUES ('admin', '0', 'admin', password('123'));

INSERT INTO brand (brand) VALUES ('Nike');
INSERT INTO brand (brand) VALUES ('Adidas');
INSERT INTO brand (brand) VALUES ('Puma');
INSERT INTO brand (brand) VALUES ('Herschel');
INSERT INTO brand (brand) VALUES ('G-Star');

INSERT INTO typearticle (typeArticle) VALUES ('Habit');
INSERT INTO typearticle (typeArticle) VALUES ('Chaussure');
INSERT INTO typearticle (typeArticle) VALUES ('Sac à dos');

INSERT INTO model (model_name, model_prix, fk_typeArticle, fk_brand) VALUES ('Blazer', '100', '2', '1');
INSERT INTO model (model_name, model_prix, fk_typeArticle, fk_brand) VALUES ('Blazer LOW', '100', '2', '1');
INSERT INTO model (model_name, model_prix, fk_typeArticle, fk_brand) VALUES ('Gazelle', '90', '2', '2');
INSERT INTO model (model_name, model_prix, fk_typeArticle, fk_brand) VALUES ('Classic', '85', '2', '3');
INSERT INTO model (model_name, model_prix, fk_typeArticle, fk_brand) VALUES ('Retreat', '100', '3', '4');
INSERT INTO model (model_name, model_prix, fk_typeArticle, fk_brand) VALUES ('ARC-Z 3D SLIM', '120', '1', '5');

INSERT INTO color (color) VALUES ('Noir');
INSERT INTO color (color) VALUES ('Blanc');
INSERT INTO color (color) VALUES ('Rouge');
INSERT INTO color (color) VALUES ('Vert');
INSERT INTO color (color) VALUES ('Bleu');
INSERT INTO color (color) VALUES ('Gris');

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
INSERT INTO size (size) VALUES ('Unique');
INSERT INTO size (size) VALUES ('XS');
INSERT INTO size (size) VALUES ('M');
INSERT INTO size (size) VALUES ('L');
INSERT INTO size (size) VALUES ('XL');
INSERT INTO size (size) VALUES ('32x34');
INSERT INTO size (size) VALUES ('34x34');
INSERT INTO size (size) VALUES ('36x34');

INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '1', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '2', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '3', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '4', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '5', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '6', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '7', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '8', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '9', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '10', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-noir.jpg', '1', '11', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-blanche-low.jpg', '2', '9', '2');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-blanche-low.jpg', '2', '10', '2');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'blazer-blanche-low.jpg', '2', '11', '2');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'classic-noir.jpg', '4', '1', '1');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'herschel-gris.jpg', '5', '12', '6');
INSERT INTO article (quantity, illustration, fk_model, fk_size, fk_color) VALUES ('5', 'g-star-bleu.jpg', '6', '18', '5');
