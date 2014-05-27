<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.0
 * @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
 */
class Bubble_StockMovements_Model_Api2_Stock_Movement extends Mage_Api2_Model_Resource
{
    /**
     * Load stock item by id
     *
     * @param int $id
     * @throws Mage_Api2_Exception
     * @return Mage_CatalogInventory_Model_Stock_Item
     */
    protected function _loadStockItemById($id)
    {
        
        /* @var $stockItem Mage_CatalogInventory_Model_Stock_Item */
        $stockItem = Mage::getModel('bubble_stockmovements/stock_movement')->load($id);        
        if (!$stockItem->getId()) {
            $this->_critical(self::RESOURCE_NOT_FOUND);
        }
        return $stockItem;
    }
}
