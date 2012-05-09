<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$tableHistory = $installer->getTable('cataloginventory_stock_history');
$tableItem    = $installer->getTable('cataloginventory_stock_item');
$tableUser    = $installer->getTable('admin/user');

$installer->run("
DROP TABLE IF EXISTS {$tableHistory};
CREATE TABLE {$tableHistory} (
`history_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`item_id` INT( 10 ) UNSIGNED NOT NULL ,
`user` varchar(40) NOT NULL DEFAULT '',
`user_id` mediumint(9) unsigned DEFAULT NULL,
`qty` DECIMAL( 12, 4 ) NOT NULL default '0',
`is_in_stock` TINYINT( 1 ) UNSIGNED NOT NULL default '0',
`message` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`created_at` DATETIME NOT NULL ,
INDEX ( `item_id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");

$installer->getConnection()->addConstraint('FK_STOCK_HISTORY_ITEM', $tableHistory, 'item_id', $tableItem, 'item_id');
$installer->getConnection()->addConstraint('FK_STOCK_HISTORY_USER', $tableHistory, 'user_id', $tableUser, 'user_id', 'SET NULL');

$installer->endSetup();
