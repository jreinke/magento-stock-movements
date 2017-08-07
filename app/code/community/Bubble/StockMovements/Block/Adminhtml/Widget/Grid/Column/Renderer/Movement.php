<?php

class Bubble_StockMovements_Block_Adminhtml_Widget_Grid_Column_Renderer_Movement
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function renderExport(Varien_Object $row)
    {
        // return the raw value for the export
        return parent::_getValue($row);
    }

    protected function _getValue(Varien_Object $row)
    {
        $value = parent::_getValue($row);

        $html = sprintf(
            '<a href="%s" title="%s">%s</a>',
            $this->getUrl('adminhtml/catalog_product/edit', array('id' => $row->getProductId())),
            Mage::helper('bubble_stockmovements')->__('Edit Product'),
            $value
        );

        return $html;
    }

}
