<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
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