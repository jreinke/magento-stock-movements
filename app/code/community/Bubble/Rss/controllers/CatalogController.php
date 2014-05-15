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
        $this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
        $this->loadLayout(false);
        $this->renderLayout();
    }
    //This will prompt for admin user and password to view the rss
    public function preDispatch()
    {
        if ($this->getRequest()->getActionName() == 'stockmovements') {
            $this->_currentArea = 'adminhtml';
            Mage::helper('rss')->authAdmin('catalog/stockmovements');
        }
        return parent::preDispatch();
    }
}