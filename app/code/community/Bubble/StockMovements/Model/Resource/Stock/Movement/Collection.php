<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.0.0
 * @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
 */
class Bubble_StockMovements_Model_Resource_Stock_Movement_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('bubble_stockmovements/stock_movement');
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
                $prevItem->setMovement($move);
                $prevItem = $item;
            }
        }
        if ($prevItem) {
            $prevItem->setMovement('-');
        }

        return $this;
    }
}