<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.1
 * @copyright   Copyright (c) 2014 BubbleShop (http://www.bubbleshop.net)
 */
class Bubble_StockMovements_Adminhtml_Stock_MovementController extends Mage_Adminhtml_Controller_Action
{
    public function listAction()
    {
        $this->_title($this->__('Catalog'))
            ->_title(Mage::helper('bubble_stockmovements')->__('Stock Movements'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('bubble_stockmovements/adminhtml_stock_movement'));
        $this->_setActiveMenu('catalog/stock_movements');
        $this->renderLayout();
    }
}