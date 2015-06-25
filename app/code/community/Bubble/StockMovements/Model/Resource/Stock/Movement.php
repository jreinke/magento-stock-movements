<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_StockMovements_Model_Resource_Stock_Movement extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('bubble_stockmovements/stock_movement', 'movement_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getCreatedAt()) {
            $object->setCreatedAt($this->formatDate(time()));
        }

        return parent::_beforeSave($object);
    }

    public function insertStocksMovements($stocksMovements)
    {
        $this->_getWriteAdapter()->insertMultiple($this->getMainTable(), $stocksMovements);

        return $this;
    }

    public function getProductsIdBySku($skus)
    {
        $select = $this->getReadConnection()
            ->select()
            ->from($this->getTable('catalog/product'), array('entity_id'))
            ->where('sku IN (?)', (array) $skus);

        return $this->getReadConnection()->fetchCol($select);
    }
}