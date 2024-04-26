CREATE DATABASE IF NOT EXISTS `easypay_examples`;
USE `easypay_examples`;

CREATE TABLE `easypay_payments` (
  `ep_key` INT(11) NOT NULL AUTO_INCREMENT,
  `easypay_reference_id` INT(11) NULL DEFAULT NULL,
  `ep_doc` VARCHAR(50) NULL DEFAULT NULL,
  `ep_cin` VARCHAR(20) NULL DEFAULT NULL,
  `ep_user` VARCHAR(20) NULL DEFAULT NULL,
  `ep_status` VARCHAR(20) NULL DEFAULT 'pending',
  `ep_message` VARCHAR(500) NULL DEFAULT NULL,
  `ep_entity` VARCHAR(10) NULL DEFAULT NULL,
  `ep_reference` VARCHAR(9) NULL DEFAULT NULL,
  `ep_value` DOUBLE NULL DEFAULT NULL,
  `ep_date` DATETIME NULL DEFAULT NULL COMMENT 'Coluna preenchida em pagamentos por MB',
  `ep_payment_type` VARCHAR(10) NULL DEFAULT NULL,
  `ep_value_fixed` DOUBLE NULL DEFAULT NULL,
  `ep_value_var` DOUBLE NULL DEFAULT NULL,
  `ep_value_tax` DOUBLE NULL DEFAULT NULL,
  `ep_value_transf` DOUBLE NULL DEFAULT NULL,
  `ep_date_transf` DATE NULL DEFAULT NULL,
  `t_key` VARCHAR(255) NULL DEFAULT NULL,
  `payment_at` TIMESTAMP NULL DEFAULT NULL,
  `next_payment_at` TIMESTAMP NULL DEFAULT NULL,
  `next_payment_requested` TINYINT(4) NOT NULL DEFAULT '0',
  `next_value` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`ep_key`),
  UNIQUE INDEX `ep_doc` (`ep_doc`),
  INDEX `fk_easypay_payment_easypay_reference` (`easypay_reference_id`),
  CONSTRAINT `fk_easypay_payment_easypay_reference` FOREIGN KEY (`easypay_reference_id`) REFERENCES `easypay_references` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
  COLLATE='utf8_general_ci'
  ENGINE=InnoDB
;

CREATE TABLE `easypay_references` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ep_cin` INT(20) NOT NULL,
  `ep_status` VARCHAR(50) NULL DEFAULT NULL,
  `ep_message` TEXT NULL,
  `ep_entity` INT(10) NOT NULL,
  `ep_reference` VARCHAR(50) NOT NULL,
  `ep_k1` VARCHAR(255) NULL DEFAULT NULL,
  `t_key` INT(11) NOT NULL,
  `o_obs` TEXT NULL,
  `o_mobile` VARCHAR(255) NULL DEFAULT NULL,
  `o_email` VARCHAR(255) NULL DEFAULT NULL,
  `ep_value` FLOAT NOT NULL,
  `link` TEXT NULL,
  `ep_link_rp_dd` TEXT NULL,
  `ep_link_rp_cc` TEXT NULL,
  `ep_currency` VARCHAR(255) NULL DEFAULT NULL,
  `ep_periodicity` VARCHAR(255) NULL DEFAULT NULL,
  `ep_max_debit` INT(11) NULL DEFAULT NULL,
  `ep_max_auth` FLOAT NULL DEFAULT NULL,
  `ep_expiry_date` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `id` (`id`),
  INDEX `fk_t_key` (`t_key`),
  CONSTRAINT `fk_t_key` FOREIGN KEY (`t_key`) REFERENCES `orders` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
  COLLATE='utf8_general_ci'
  ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `some_field` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Here is where you store your orders';

