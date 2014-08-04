<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.1
 * @copyright   Copyright (c) 2014 BubbleShop (http://www.bubbleshop.net)
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

    public function joinProduct()
    {
        $this->getSelect()
            ->joinLeft(
                array('stock_item' => $this->getTable('cataloginventory/stock_item')),
                'main_table.item_id = stock_item.item_id',
                'product_id'
            )
            ->joinLeft(
                array('product' => $this->getTable('catalog/product')),
                'stock_item.product_id = product.entity_id',
                array('sku' => 'product.sku')
            );

        return $this;
    }
}