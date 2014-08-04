<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.1
 * @copyright   Copyright (c) 2014 BubbleShop (http://www.bubbleshop.net)
 */
class Bubble_StockMovements_Block_Adminhtml_Stock_Movement_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('StockMovementGrid');
        $this->setSaveParametersInSession(true);
        $this->setFilterVisibility(!$this->getProduct());
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
    }

    public function getProduct()
    {
        return Mage::registry('current_product');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bubble_stockmovements/stock_movement')->getCollection();

        if ($this->getProduct()) {
            $stockItem = Mage::getModel('cataloginventory/stock_item')
                ->loadByProduct($this->getProduct()->getId());
            if ($stockItem->getId()) {
                $collection->addFieldToFilter('item_id', $stockItem->getId());
            }
        } else {
            $collection->joinProduct();
        }

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        if (!$this->getProduct()) {
            $this->addColumn('sku', array(
                'header'         => Mage::helper('bubble_stockmovements')->__('SKU'),
                'index'          => 'sku',
                'filter_index'   => 'product.sku',
                'type'           => 'text',
                'frame_callback' => array($this, 'decorateSku'),
            ));
        }

        $this->addColumn('qty', array(
            'header'        => Mage::helper('bubble_stockmovements')->__('Quantity'),
            'align'         => 'right',
            'index'         => 'qty',
            'type'          => 'number',
            'width'         => '80px',
            'filter_index'  => 'main_table.qty',
        ));

        $this->addColumn('movement', array(
            'header'        => Mage::helper('bubble_stockmovements')->__('Movement'),
            'align'         => 'right',
            'index'         => 'movement',
            'width'         => '80px',
            'filter'        => false,
        ));

        $this->addColumn('is_in_stock', array(
            'header'        => Mage::helper('bubble_stockmovements')->__('In Stock'),
            'align'         => 'right',
            'index'         => 'is_in_stock',
            'type'          => 'options',
            'options'       => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'width'         => '80px',
            'filter_index'  => 'main_table.is_in_stock',
        ));

        $this->addColumn('message', array(
            'header'        => Mage::helper('bubble_stockmovements')->__('Message'),
            'align'         => 'left',
            'index'         => 'message',
        ));

        $this->addColumn('user', array(
            'header'        => Mage::helper('bubble_stockmovements')->__('User'),
            'align'         => 'center',
            'index'         => 'user',
        ));

        $this->addColumn('created_at', array(
            'header'        => Mage::helper('bubble_stockmovements')->__('Date'),
            'align'         => 'right',
            'index'         => 'created_at',
            'type'          => 'datetime',
            'width'         => '180px',
            'filter_index'  => 'main_table.created_at',
        ));

        return parent::_prepareColumns();
    }

    public function decorateSku($value, $row)
    {
        $html = sprintf(
            '<a href="%s" title="%s">%s</a>',
            $this->getUrl('adminhtml/catalog_product/edit', array('id' => $row->getProductId())),
            Mage::helper('bubble_stockmovements')->__('Edit Product'),
            $value
        );

        return $html;
    }
}