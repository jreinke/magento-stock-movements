<?php
/**
* @category    Bubble
* @package     Bubble_StockMovements
* @version     1.2.0
* @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
*/
class Bubble_Rss_Model_Observer extends Mage_Rss_Model_Observer
{
    public function clearCacheStockMovements(Varien_Event_Observer $observer)
    {
        Mage::log("Bubble_Rss_Model_Stock_Observer clearCacheStockMovements",Zend_Log::DEBUG,'magento-stock-movements.log',true);
        $this->_cleanCache(Bubble_Rss_Block_Catalog_StockMovements::CACHE_TAG);
        return $this;
    }
}
