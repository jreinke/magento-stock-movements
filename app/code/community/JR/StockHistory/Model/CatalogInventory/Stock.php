<?php

class JR_StockHistory_Model_CatalogInventory_Stock extends Mage_CatalogInventory_Model_Stock
{
    public function revertProductsSale($items)
    {
        parent::revertProductsSale($items);
        Mage::dispatchEvent('cataloginventory_stock_revert_products_sale', array('items' => $items));

        return $this;
    }
}