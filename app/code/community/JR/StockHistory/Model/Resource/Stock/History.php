<?php

class JR_StockHistory_Model_Resource_Stock_History extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('jr_stockhistory/stock_history', 'history_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (! $object->getCreatedAt()) {
            $object->setCreatedAt($this->formatDate(time()));
        }

        return parent::_beforeSave($object);
    }

    public function insertStocksHistory($stocksHistory)
    {
        $this->_getWriteAdapter()->insertMultiple($this->getMainTable(), $stocksHistory);

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