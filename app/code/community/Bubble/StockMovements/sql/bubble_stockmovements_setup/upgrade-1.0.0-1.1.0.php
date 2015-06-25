<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$tableMovement  = $installer->getTable('bubble_stock_movement');

$installer->getConnection()->dropForeignKey($tableMovement, 'FK_STOCK_MOVEMENT_USER');

$installer->run("
    ALTER TABLE `{$tableMovement}`
        ADD COLUMN `is_admin` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `user_id`;
");

$installer->endSetup();
