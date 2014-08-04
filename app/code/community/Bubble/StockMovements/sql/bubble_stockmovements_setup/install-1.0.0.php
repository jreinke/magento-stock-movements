<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.1
 * @copyright   Copyright (c) 2014 BubbleShop (http://www.bubbleshop.net)
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$tableMovement  = $installer->getTable('bubble_stock_movement');
$tableItem      = $installer->getTable('cataloginventory_stock_item');
$tableUser      = $installer->getTable('admin/user');

$installer->run("
DROP TABLE IF EXISTS {$tableMovement};
CREATE TABLE {$tableMovement} (
`movement_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
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

$installer->getConnection()->addConstraint('FK_STOCK_MOVEMENT_ITEM', $tableMovement, 'item_id', $tableItem, 'item_id');
$installer->getConnection()->addConstraint('FK_STOCK_MOVEMENT_USER', $tableMovement, 'user_id', $tableUser, 'user_id', 'SET NULL');

$installer->endSetup();
