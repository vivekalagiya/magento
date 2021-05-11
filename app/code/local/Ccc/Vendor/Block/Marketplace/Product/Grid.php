<?php

class Ccc_Vendor_Block_Marketplace_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('product_filter');
    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    public function getRequestStatus()
    {
        $vendorId = Mage::getModel('vendor/session')->getVendor()->getId();
        $collection = Mage::getModel('vendor/product_request')->getCollection()
            ->addFilter('vendor_id', $vendorId);
        return $collection;
    }

    public function getProducts()
    {
        $store = $this->_getStore();
        $collection = Mage::getModel('vendor/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id');
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        // $collection->addStoreFilter($store);
        $collection->joinAttribute(
            'name',
            'vendor_product/name',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'sku',
            'vendor_product/sku',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'status',
            'vendor_product/status',
            'entity_id',
            null,
            'inner',
            $store->getId()
        );
        $collection->joinAttribute(
            'visibility',
            'vendor_product/visibility',
            'entity_id',
            null,
            'inner',
            $store->getId()
        );
        $collection->joinAttribute(
            'price',
            'vendor_product/price',
            'entity_id',
            null,
            'left',
            $store->getId()
        );

        
        $collection->addFilter('vendor_id', ['eq' => Mage::getSingleton('vendor/session')->getVendor()->getId()]);

        return $collection;
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField(
                    'websites',
                    'vendor/product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left'
                );
            }
        }
        return parent::_addColumnFilterToCollection($column);
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('vendor')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
            )
        );

        $store = $this->_getStore();
        if ($store->getId()) {
            $this->addColumn(
                'name',
                array(
                    'header' => Mage::helper('vendor')->__('Name in %s', $store->getName()),
                    'index' => 'custom_name',
                )
            );
        }

        // $this->addColumn(
        //     'type',
        //     array(
        //         'header' => Mage::helper('vendor')->__('Type'),
        //         'width' => '60px',
        //         'index' => 'type_id',
        //         'type'  => 'options',
        //         'options' => Mage::getSingleton('vendor/product_type')->getOptionArray(),
        //     )
        // );

        // $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
        //     ->setEntityTypeFilter(Mage::getModel('vendor/product')->getResource()->getTypeId())
        //     ->load()
        //     ->toOptionHash();

        // $this->addColumn(
        //     'set_name',
        //     array(
        //         'header' => Mage::helper('vendor')->__('Attrib. Set Name'),
        //         'width' => '100px',
        //         'index' => 'attribute_set_id',
        //         'type'  => 'options',
        //         'options' => $sets,
        //     )
        // );

        $this->addColumn(
            'sku',
            array(
                'header' => Mage::helper('vendor')->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
            )
        );

        $store = $this->_getStore();
        $this->addColumn(
            'price',
            array(
                'header' => Mage::helper('vendor')->__('Price'),
                'type'  => 'price',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
            )
        );

        $this->addColumn(
            'visibility',
            array(
                'header' => Mage::helper('vendor')->__('Visibility'),
                'width' => '70px',
                'index' => 'visibility',
                'type'  => 'options',
                'options' => Mage::getModel('vendor/product')->getOptionArray(),
            )
        );

        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('vendor')->__('Status'),
                'width' => '70px',
                'index' => 'status',
                'type'  => 'options',
                'options' => Mage::getSingleton('vendor/product')->getOptionArray(),
            )
        );

        $this->addColumn(
            'action',
            array(
                'header'    => Mage::helper('vendor')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('vendor')->__('Edit'),
                        'url'     => array(
                            'base' => '*/*/edit',
                            'params' => array('store' => $this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
            )
        );

        if (Mage::helper('vendor')->isModuleEnabled('Mage_Rss')) {
            $this->addRssList('rss/vendor/notifystock', Mage::helper('vendor')->__('Notify Low Stock RSS'));
        }

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            array(
                'store' => $this->getRequest()->getParam('store'),
                'id' => $row->getId()
            )
        );
    }
    public function getAddUrl()
    {
        return $this->getUrl('*/product/new');
    }
    public function getPagetHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getEditUrl()
    {
        return $this->getUrl('*/product/edit');
    }
    public function getdeleteUrl()
    {
        return $this->getUrl('*/product/delete');
    }
}
