<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_StockMovements_Block_Adminhtml_Stock_Movement extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'bubble_stockmovements';
        $this->_controller = 'adminhtml_stock_movement';
        $this->_headerText = Mage::helper('bubble_stockmovements')->__('Stock Movements');
        $this->_removeButton('add');
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock(
            'bubble_stockmovements/adminhtml_stock_movement_grid',
            'stock_movements.grid'
        ));

        return parent::_prepareLayout();
    }

    public function getHeaderCssClass()
    {
        return '';
    }
}