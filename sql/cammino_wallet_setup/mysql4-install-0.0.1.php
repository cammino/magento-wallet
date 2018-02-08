<?php
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$installer->run("ALTER TABLE `". $installer->getTable('sales/order') ."` ADD `wallet_debit` DECIMAL(12,4) NULL");
$installer->run("ALTER TABLE `". $installer->getTable('sales/order') ."` ADD `base_wallet_debit` DECIMAL(12,4) NULL");
$installer->run("ALTER TABLE `". $installer->getTable('sales/quote') ."` ADD `wallet_debit` DECIMAL(12,4) NULL");
$installer->run("ALTER TABLE `". $installer->getTable('sales/quote') ."` ADD `base_wallet_debit` DECIMAL(12,4) NULL");


$installer->run("CREATE TABLE IF NOT EXISTS `{$installer->getTable('cammino_wallet')}` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `entity_id` INT(10) UNSIGNED NOT NULL,
  `total_credit` DECIMAL(12,4) NOT NULL DEFAULT '0.0000',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_CAMMINO_WALLET_ENTITY_ID` 
  	FOREIGN KEY (`entity_id`) 
  	REFERENCES `{$installer->getTable('customer_entity')}` (`entity_id`) 
  	ON DELETE CASCADE 
  	ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->run("CREATE TABLE IF NOT EXISTS `{$installer->getTable('cammino_wallet_log')}` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `wallet_id` INT(10) UNSIGNED NOT NULL,
  `value` DECIMAL(12,4) NOT NULL DEFAULT '0.0000',
  `type` ENUM('debit', 'credit') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_CAMMINO_WALLET_WALLET_ID` 
  	FOREIGN KEY (`wallet_id`) 
  	REFERENCES `{$installer->getTable('cammino_wallet')}` (`id`) 
  	ON DELETE CASCADE 
  	ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();