<?php
/**
 * @category    Bubble
 * @package     Bubble_StockMovements
 * @version     1.2.1
 * @copyright   Copyright (c) 2014 BubbleShop (http://www.bubbleshop.net)
 */
class Bubble_StockMovements_Model_Stock_Movement extends Mage_Core_Model_Abstract
{
    const ENTITY = 'stock_movement';

    protected $_eventObject = 'movement';

    protected function _construct()
    {
        $this->_init('bubble_stockmovements/stock_movement');
    }
}