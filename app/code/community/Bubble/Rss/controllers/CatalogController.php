<?php
/**
* @category    Bubble
* @package     Bubble_StockMovements
* @version     1.2.0
* @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
*/
// Controllers are not autoloaded so we will have to do it manually:
require_once 'Mage/Rss/controllers/CatalogController.php';
class Bubble_Rss_CatalogController extends Mage_Rss_CatalogController
{
    public function stockmovementsAction()
    {
        Mage::log("Bubble_Rss_CatalogController stockmovementsAction",Zend_Log::DEBUG,'magento-stock-movements.log',true);
        $this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
        $this->loadLayout(false)->renderLayout();
    }
    //This will prompt for admin user and password to view the rss
    public function preDispatch()
    {
        Mage::log("Bubble_Rss_CatalogController preDispatch",Zend_Log::DEBUG,'magento-stock-movements.log',true);
        if ($this->getRequest()->getActionName() == 'stockmovements') {
            $this->_currentArea = 'adminhtml';
            Mage::helper('rss')->authAdmin('catalog/stock_movement');
        }
        return parent::preDispatch();
    }
}