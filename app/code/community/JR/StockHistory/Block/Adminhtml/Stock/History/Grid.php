<?php

class JR_StockHistory_Block_Adminhtml_Stock_History_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('StockHistoryGrid')
            ->setSaveParametersInSession(true)
            ->setFilterVisibility(false);
    }

    protected function _prepareCollection()
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')
            ->loadByProduct($this->getRequest()->getParam('id'));
        $collection = Mage::getModel('jr_stockhistory/stock_history')->getCollection()
            ->setOrder('history_id', 'desc');

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
          'header'    => Mage::helper('jr_stockhistory')->__('Quantity'),
          'align'     => 'right',
          'index'     => 'qty',
          'type'      => 'number',
          'width'     => '80px',
        ));

        $this->addColumn('move', array(
            'header'    => Mage::helper('jr_stockhistory')->__('Move'),
            'align'     => 'right',
            'index'     => 'move',
            'width'     => '80px',
        ));

        $this->addColumn('is_in_stock', array(
          'header'    => Mage::helper('jr_stockhistory')->__('In Stock'),
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
          'header'    => Mage::helper('jr_stockhistory')->__('Message'),
          'align'     => 'left',
          'index'     => 'message',
        ));

        $this->addColumn('user', array(
          'header'    => Mage::helper('jr_stockhistory')->__('User'),
          'align'     => 'center',
          'index'     => 'user',
        ));

        $this->addColumn('created_at', array(
          'header'    => Mage::helper('jr_stockhistory')->__('Date'),
          'align'     => 'right',
          'index'     => 'created_at',
          'type'      => 'datetime',
          'width'     => '180px',
        ));

        return parent::_prepareColumns();
    }
}