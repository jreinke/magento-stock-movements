<?php

class JR_StockHistory_Model_Stock_Observer
{
    public function addStockHistoryTab()
    {
        $layout = Mage::getSingleton('core/layout');
        $layout->getBlock('product_tabs')
            ->addTab('stock_history', array(
                'after' => 'inventory',
                'label' => Mage::helper('jr_stockhistory')->__('Stock History'),
                'content' => $layout->createBlock('jr_stockhistory/adminhtml_stock_history_grid')->toHtml(),
            ));
    }

    public function cancelOrderItem($observer)
    {
        $item = $observer->getEvent()->getItem();

        $children = $item->getChildrenItems();
        $qty = $item->getQtyOrdered() - max($item->getQtyShipped(), $item->getQtyInvoiced()) - $item->getQtyCanceled();

        if ($item->getId() && ($productId = $item->getProductId()) && empty($children) && $qty) {
            Mage::getSingleton('cataloginventory/stock')->backItemQty($productId, $qty);
            $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($item->getProductId());
            $this->insertStockHistory($stockItem, sprintf(
                'Product restocked after order cancellation (order: %s)',
                $item->getOrder()->getIncrementId())
            );
        }

        return $this;
    }

    public function catalogProductImportFinishBefore($observer)
    {
        $adapter = $observer->getEvent()->getAdapter();
        Mage_ImportExport_Model_Import::getDataSourceModel()->getIterator()->rewind();
        $model = Mage::getModel('catalog/product');
        $skus = array();
        while ($bunch = $adapter->getNextBunch()) {
            foreach ($bunch as $rowData) {
                if (null !== $rowData['sku']) {
                    $skus[] = $rowData['sku'];
                }
            }
        }

        if (!empty($skus)) {
            $resource = Mage::getResourceModel('jr_stockhistory/stock_history');
            $productIds = $resource->getProductsIdBySku($skus);
            if (!empty($productIds)) {
                $stock = Mage::getSingleton('cataloginventory/stock');
                $stocks = Mage::getResourceModel('cataloginventory/stock')->getProductsStock($stock, $productIds);
                $stocksHistory = array();
                $datetime = Varien_Date::formatDate(time());
                foreach ($stocks as $stockData) {
                    $stocksHistory[] = array(
                        'item_id'     => $stockData['item_id'],
                        'user'        => $this->_getUsername(),
                        'user_id'     => $this->_getUserId(),
                        'qty'         => $stockData['qty'],
                        'is_in_stock' => (int) $stockData['is_in_stock'],
                        'message'     => 'Product import',
                        'created_at'  => $datetime,
                    );
                }

                if (!empty($stocksHistory)) {
                    $resource->insertStocksHistory($stocksHistory);
                }
            }
        }
    }

    public function checkoutAllSubmitAfter($observer)
    {
        if ($observer->getEvent()->hasOrders()) {
            $orders = $observer->getEvent()->getOrders();
        } else {
            $orders = array($observer->getEvent()->getOrder());
        }
        $stockItems = array();
        foreach ($orders as $order) {
            foreach ($order->getAllItems() as $orderItem) {
                if ($orderItem->getQtyOrdered()) {
                    $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($orderItem->getProductId());
                    if (!isset($stockItems[$stockItem->getId()])) {
                        $stockItems[$stockItem->getId()] = array(
                            'item'   => $stockItem,
                            'orders' => array($order->getIncrementId()),
                        );
                    } else {
                        $stockItems[$stockItem->getId()]['orders'][] = $order->getIncrementId();
                    }
                }
            }
        }

        if (!empty($stockItems)) {
            foreach ($stockItems as $data) {
                $this->insertStockHistory($stockItem, sprintf(
                    'Product ordered (order%s: %s)',
                    count($data['orders']) > 1 ? 's' : '',
                    implode(', ', $data['orders'])
                ));
            }
        }
    }

    public function insertStockHistory(Mage_CatalogInventory_Model_Stock_Item $stockItem, $message = '')
    {
        Mage::getModel('jr_stockhistory/stock_history')
            ->setItemId($stockItem->getId())
            ->setUser($this->_getUsername())
            ->setUserId($this->_getUserId())
            ->setQty($stockItem->getQty())
            ->setIsInStock((int) $stockItem->getIsInStock())
            ->setMessage($message)
            ->save();
        Mage::getModel('catalog/product')->load($stockItem->getProductId())->cleanCache();
    }

    public function saveStockItemAfter($observer)
    {
        $stockItem = $observer->getEvent()->getItem();
        if (! $stockItem->getStockStatusChangedAutomaticallyFlag()) {
            if (! $message = $stockItem->getSaveHistoryMessage()) {
                if (Mage::getSingleton('api/session')->getSessionId()) {
                    $message = 'Stock saved from Magento API';
                } else {
                    $message = 'Stock saved manually';
                }
            }
            $this->insertStockHistory($stockItem, $message);
        }
    }

    public function stockRevertProductsSale($observer)
    {
        $items = $observer->getEvent()->getItems();
        foreach ($items as $productId => $item) {
            $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);
            if ($stockItem->getId()) {
                $message = 'Product restocked';
                if ($creditMemo = Mage::registry('current_creditmemo')) {
                    $message = sprintf('Product restocked after credit memo creation (credit memo: %s)', $creditMemo->getIncrementId());
                }
                $this->insertStockHistory($stockItem, $message);
            }
        }
    }

    protected function _getUserId()
    {
        $userId = null;
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        }

        return $userId;
    }

    protected function _getUsername()
    {
        $username = '-';
        if (Mage::getSingleton('api/session')->isLoggedIn()) {
            $username = Mage::getSingleton('api/session')->getUser()->getUsername();
        } elseif (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $username = Mage::getSingleton('admin/session')->getUser()->getUsername();
        }

        return $username;
    }
}