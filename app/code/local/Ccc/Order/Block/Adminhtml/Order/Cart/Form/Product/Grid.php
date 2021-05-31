<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Form_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
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
        $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku','inner')
            ->addAttributeToSelect('name','inner')
            ->addAttributeToSelect('attribute_set_id','inner')
            ->addAttributeToSelect('type_id','inner');

        if (Mage::helper('order')->isModuleEnabled('Mage_CatalogInventory')) {
            $collection->joinField('qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left');
        }
        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                'name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $adminStore
            );
            $collection->joinAttribute(
                'price',
                'catalog_product/price',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
        }
        else {
            $collection->addAttributeToSelect('price');
        }
        $collection->addFieldToFilter('price',['neq' => '']);
        $collection->addFieldToFilter('name',['neq' => '']);
        $this->setCollection($collection);

        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

   

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id',
            array(
                'header'=> Mage::helper('order')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
        ));
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('order')->__('Name'),
                'index' => 'name',
        ));

        // $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
        //     ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
        //     ->load()
        //     ->toOptionHash();


        $this->addColumn('sku',
            array(
                'header'=> Mage::helper('order')->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
        ));

        $store = $this->_getStore();
        $this->addColumn('price',
            array(
                'header'=> Mage::helper('order')->__('Price'),
                'type'  => 'price',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
        ));


        // if (Mage::helper('order')->isModuleEnabled('Mage_Rss')) {
        //     $this->addRssList('rss/catalog/notifystock', Mage::helper('order')->__('Notify Low Stock RSS'));
        // }

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('addToCart', array(
             'label'=> Mage::helper('order')->__('Add To Cart'),
             'url'  => $this->getUrl('*/*/addToCart')
        ));

       return $this;
    }

}
