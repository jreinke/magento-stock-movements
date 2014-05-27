<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.0
 * @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
 */
abstract class Bubble_StockMovements_Model_Api2_Stock_Movement_Rest
    extends Bubble_StockMovements_Model_Api2_Stock_Movement
{
    /**
     * Retrieve information about specified stock item
     *
     * @throws Mage_Api2_Exception
     * @return array
     */
    protected function _retrieve()
    {
        /* @var $stockItem Mage_CatalogInventory_Model_Stock_Item */
        $stockItem = $this->_loadStockItemById($this->getRequest()->getParam('id'));
        return $stockItem->getData();
    }

    /**
     * Get stock items list
     *
     * @return array
     */
    protected function _retrieveCollection()
    {
        $data = $this->_getCollectionForRetrieve()->load()->toArray();
        return isset($data['items']) ? $data['items'] : $data;
    }

    /**
     * Retrieve stock items collection
     *
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    protected function _getCollectionForRetrieve()
    {
        /* @var $collection Mage_CatalogInventory_Model_Resource_Stock_Item_Collection */
        $collection = Mage::getResourceModel('bubble_stockmovements/stock_movement_collection');
        
        $this->_applyCollectionModifiers($collection);
        return $collection;
    }
}
