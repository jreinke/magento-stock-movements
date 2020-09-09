<?php

require_once Mage::getModuleDir('controllers', 'Mage_Paypal') . DS . 'ExpressController.php';

class Bubble_StockMovements_ExpressController extends Mage_Paypal_ExpressController
{
    public function placeOrderAction()
    {
        parent::placeOrderAction();
        if ($this->_checkout instanceof Mage_Paypal_Model_Express_Checkout
            && $this->_quote instanceof Mage_Sales_Model_Quote
            && $this->_checkout->getOrder() instanceof Mage_Sales_Model_Order) {
            Mage::dispatchEvent(
                'bubble_stockmovements_paypal_express_checkout_submit_all_after',
                ['order' => $this->_checkout->getOrder(), 'quote' => $this->_quote]);
        }
    }
}
