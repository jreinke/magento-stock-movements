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

    /**
     * Export stock movements value as CSV file
     *
     * @return void
     */
    public function exportStockMovementCsvAction()
    {
        $fileName = 'stock_movements.csv';
        $content  = $this->getLayout()
            ->createBlock('bubble_stockmovements/adminhtml_stock_movement_grid')
            ->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export stock movements as excel xml file
     *
     * @return void
     */
    public function exportStockMovementXmlAction()
    {
        $fileName = 'stock_movements.xml';
        $content  = $this->getLayout()
            ->createBlock('bubble_stockmovements/adminhtml_stock_movement_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
}