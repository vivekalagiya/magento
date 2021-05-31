<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Form_CartItem_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('cartItemGrid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        // $this->setUseAjax(true);
        // $this->setVarNameFilter('product_filter');

    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection()
    {
        $cartId = $this->getCart()->getId();
        $store = $this->_getStore();
        $collection = Mage::getModel('order/cart_item')->getCollection()
            ->addFieldToFilter('cart_id',['eq' => $cartId]);

        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('order')->__('Name'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'name',
            ));
            $this->addColumn('sku',
            array(
                'header'=> Mage::helper('order')->__('Sku'),
                'width' => '50px',
                'index' => 'sku',
        ));

        // $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
        //     ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
        //     ->load()
        //     ->toOptionHash();


        $this->addColumn('base_price',
            array(
                'header'=> Mage::helper('order')->__('Price'),
                'width' => '80px',
                'index' => 'base_price',
        ));

        // $store = $this->_getStore();
        // $this->addColumn('price',
        //     array(
        //         'header'=> Mage::helper('order')->__('Price'),
        //         'type'  => 'price',
        //         'currency_code' => $store->getBaseCurrency()->getCode(),
        //         'index' => 'price',
        // ));

        $this->addColumn('quantity',
            array(
                'header'=> Mage::helper('order')->__('Quantity'),
                'width' => '80px',
                'index' => 'quantity',
        ));


        // if (Mage::helper('order')->isModuleEnabled('Mage_Rss')) {
        //     $this->addRssList('rss/catalog/notifystock', Mage::helper('order')->__('Notify Low Stock RSS'));
        // }

        return parent::_prepareColumns();
    }
    
}
