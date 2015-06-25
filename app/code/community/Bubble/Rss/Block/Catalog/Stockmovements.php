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
        $this->setCacheTags(array(self::CACHE_TAG));
        /*
        * setting cache to save the rss for 10 minutes
        */
        $this->setCacheKey('rss_catalog_stockmovements');
        $this->setCacheLifetime(600);
    }
    protected function _toHtml()
    {
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
        $collection = Mage::getModel('bubble_stockmovements/stock_movement')->getCollection()->setOrder('created_at');
        if ($this->getProduct()) {
            $stockItem = Mage::getModel('cataloginventory/stock_item')
                ->loadByProduct($this->getProduct()->getId());
            if ($stockItem->getId()) {
                $collection->addFieldToFilter('item_id', $stockItem->getId());
            }
        } else {
            $collection->joinProduct();
        }
        if ($collection)
        {
            $args = array('rssObj' => $rssObj);
            $n=0;
            foreach ($collection as $row)
            {
                $n++;
                $args['row'] = $row;
                $this->addStockMovementsXmlCallback($args);
                if($n==50){break;}
            }
        }
        return $rssObj->createRssXml();
    }
    
    public function getProduct()
    {
        return Mage::registry('current_product');
    }
    
    public function addStockMovementsXmlCallback($args)
    {
        $product = Mage::getModel('catalog/product')->load($args['row']->getProductId());
        Mage::dispatchEvent('rss_catalog_category_xml_callback', $args);
        $description = $product->getName().' '.$args['row']->getQty();
        $rssObj = $args['rssObj'];
        $data = array(
            'title'         => $product->getName().' '.$args['row']->getQty(),
            'link'          => Mage::helper('adminhtml')->getUrl('adminhtml/catalog_product/edit', array('id' => $args['row']->getProductId())),
            'description'   => $description,
            'lastUpdate'    => strtotime($args['row']->getCreatedAt())
        );
        $rssObj->_addEntry($data);
    }
}