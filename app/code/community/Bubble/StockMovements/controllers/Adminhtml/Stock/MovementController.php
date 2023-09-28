<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
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

    protected function _isAllowed ()
    {
        return Mage::getSingleton ('admin/session')->isAllowed ('admin/catalog/stock_movements');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'stockmovements.csv';
        $grid     = $this->getLayout()->createBlock('bubble_stockmovements/adminhtml_stock_movement_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName   = 'stockmovements.xml';
        $grid       = $this->getLayout()->createBlock('bubble_stockmovements/adminhtml_stock_movement_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}

