<?php
/**
* @category    Bubble
* @package     Bubble_StockMovements
* @version     1.2.0
* @copyright   Copyright (c) 2013 BubbleCode (http://shop.bubblecode.net)
*/
class Bubble_Rss_Block_Catalog_Stockmovements extends Mage_Rss_Block_Abstract
{
    /*
    Cache tag constant for feed reviews
    @var string
    */
    const CACHE_TAG = 'block_html_rss_catalog_stockmovements';
    
    protected function _construct()
    {
        Mage::log("Bubble_Rss_Block_Catalog_Stockmovements _construct",Zend_Log::DEBUG,'magento-stock-movements.log',true);
        $this->setCacheTags(array(self::CACHE_TAG));
        /*
        * setting cache to save the rss for 10 minutes
        */
        $this->setCacheKey('rss_catalog_stockmovements');
        $this->setCacheLifetime(600);
    }
    protected function _toHtml()
    {
        Mage::log("Bubble_Rss_Block_Catalog_Stockmovements _toHtml",Zend_Log::DEBUG,'magento-stock-movements.log',true);
        $newurl = Mage::getUrl('rss/catalog/stockmovements');
        $title = Mage::helper('rss')->__('Stock Movements');
        
        $rssObj = Mage::getModel('rss/rss');
        $data = array(
            'title' => $title,
            'description' => $title,
            'link'        => $newurl,
            'charset'     => 'UTF-8',
        );
        $rssObj->_addHeader($data);
        
        $_movesCollection = Mage::getModel('bubble_stockmovements/stock_movement')->getCollection()->joinProduct();
        
        if ($_movesCollection)
        {
            $args = array('rssObj' => $rssObj);
            
            foreach ($_movesCollection as $_move)
            {
                $args['move'] = $_move;
                $this->addStockMovementsXmlCallback($args);
            }
        }
        return $rssObj->createRssXml();
    }
    public function addStockMovementsXmlCallback($args)
    {
        Mage::log("Bubble_Rss_Block_Catalog_StockMovements addStockMovementsXmlCallback",Zend_Log::DEBUG,'magento-stock-movements.log',true);
        Mage::log(Zend_Debug::dump($args),Zend_Log::DEBUG,'magento-stock-movements.log',true);
        $product = Mage::getModel('catalog/product')->load($args['move']['product']->getProductId());
        Mage::dispatchEvent('rss_catalog_category_xml_callback', $args);
        $extendedDescr = "<p>" . $product->getShortDescription() . "</p>";
        $description = '<table><tr>'
        . '<td><a href="'.$product->getProductUrl().'"><img src="'
        . $this->helper('catalog/image')->init($product, 'thumbnail')->resize(75, 75)
        . '" border="0" align="left" height="75" width="75"></a></td>'
        . '<td  style="text-decoration:none;">' . $extendedDescr;
        $description .= '<p>' . Mage::app()->getLocale()->currency(Mage::app()->getStore()->
        getCurrentCurrencyCode())->getSymbol() . " " . $this->helper('tax')->getPrice($product, $product->getFinalPrice(), true) . '</p>';
        $description .= '</td></tr></table>';
        $rssObj = $args['rssObj'];
        $data = array(
            'title'         => $product->getName(),
            'link'          => $product->getProductUrl(),
            'description'   => $description,
        );
        $rssObj->_addEntry($data);
    }
}