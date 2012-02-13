<?php

class JR_StockHistory_Model_Resource_Stock_History_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('jr_stockhistory/stock_history');
    }

    protected function _afterLoad()
    {
        parent::_afterLoad();

        $prevItem = null;
        foreach ($this->getItems() as $item) {
            if (null === $prevItem) {
                $prevItem = $item;
            } else {
                $move = $prevItem->getQty() - $item->getQty();
                if ($move > 0) {
                    $move = '+' . $move;
                }
                $prevItem->setMove($move);
                $prevItem = $item;
            }
        }
        if ($prevItem) {
            $prevItem->setMove('-');
        }

        return $this;
    }
}