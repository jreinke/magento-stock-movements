<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.0.0
 * @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
 */
class Bubble_StockMovements_Model_CatalogInventory_Stock extends Mage_CatalogInventory_Model_Stock
{
    public function revertProductsSale($items)
    {
        parent::revertProductsSale($items);
        Mage::dispatchEvent('cataloginventory_stock_revert_products_sale', array('items' => $items));

        return $this;
    }
}