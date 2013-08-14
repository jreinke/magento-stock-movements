<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.0.0
 * @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
 */
class Bubble_StockMovements_Block_Adminhtml_Stock_Movement_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('StockMovementGrid')
            ->setSaveParametersInSession(true)
            ->setFilterVisibility(false);
    }

    protected function _prepareCollection()
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')
            ->loadByProduct($this->getRequest()->getParam('id'));
        $collection = Mage::getModel('bubble_stockmovements/stock_movement')->getCollection()
            ->setOrder('movement_id', 'desc');

        if ($stockItem->getId()) {
            $collection->addFieldToFilter('item_id', $stockItem->getId());
        }
        else{
        	$collection->addFieldToFilter('item_id', '-1');
        }

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('qty', array(
          'header'    => Mage::helper('bubble_stockmovements')->__('Quantity'),
          'align'     => 'right',
          'index'     => 'qty',
          'type'      => 'number',
          'width'     => '80px',
        ));

        $this->addColumn('movement', array(
            'header'    => Mage::helper('bubble_stockmovements')->__('Movement'),
            'align'     => 'right',
            'index'     => 'movement',
            'width'     => '80px',
        ));

        $this->addColumn('is_in_stock', array(
          'header'    => Mage::helper('bubble_stockmovements')->__('In Stock'),
          'align'     => 'right',
          'index'     => 'is_in_stock',
          'type' => 'options',
          'options' => array(
              '1' => Mage::helper('catalog')->__('Yes'),
              '0' => Mage::helper('catalog')->__('No'),
          ),
          'width'     => '80px',
        ));

        $this->addColumn('message', array(
          'header'    => Mage::helper('bubble_stockmovements')->__('Message'),
          'align'     => 'left',
          'index'     => 'message',
        ));

        $this->addColumn('user', array(
          'header'    => Mage::helper('bubble_stockmovements')->__('User'),
          'align'     => 'center',
          'index'     => 'user',
        ));

        $this->addColumn('created_at', array(
          'header'    => Mage::helper('bubble_stockmovements')->__('Date'),
          'align'     => 'right',
          'index'     => 'created_at',
          'type'      => 'datetime',
          'width'     => '180px',
        ));

        return parent::_prepareColumns();
    }
}