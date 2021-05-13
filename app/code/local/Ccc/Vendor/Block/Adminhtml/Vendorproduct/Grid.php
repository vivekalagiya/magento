<?php

class Ccc_Vendor_Block_Adminhtml_VendorProduct_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('vendorProductGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('vendor_filter');

    }
    
    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection()
    {
        $store = $this->_getStore();

        $collection = Mage::getModel('vendor/product')->getCollection();
            // ->addAttributeToSelect('name')
            // ->addAttributeToSelect('sku')
            // ->addAttributeToSelect('price');
            // ->addAttributeToSelect('vendor_id');

        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;

        $collection->joinAttribute(
            'name',
            'vendor_product/name',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        // $collection->joinAttribute(
        //     'sku',
        //     'vendor_product/sku',
        //     'entity_id',
        //     null,
        //     'inner',
        //     $adminStore
        // );

        $collection->joinAttribute(
            'price',
            'vendor_product/price',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        // $collection->joinAttribute(
        //     'vendor_id',
        //     'vendor_product/vendor_id',
        //     'entity_id',
        //     null,
        //     'inner',
        //     $adminStore
        // );

        $collection->joinAttribute(
            'id',
            'vendor_product/entity_id',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $requestCollection = Mage::getModel('vendor/product_request')->getCollection()
            ->addFilter('approve_status', 'pending');

        $varientCollection = new Varien_Data_Collection();

        // echo '<pre>';
        // print_r($collection->getData());die;

        foreach ($requestCollection->getData() as $request) {
            foreach ($collection->getData() as $product) {
                if($request['product_id'] == $product['entity_id']){
                    $finalArray = array_merge($request,$product);
                }
            }
            $obj = new Varien_Object();
            $obj->setData($finalArray);
            $varientCollection->addItem($obj);
        }
        
        $this->setCollection($varientCollection);
        // echo '<pre>';
        // print_r($varientCollection);die;
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('vendor')->__('id'),
                'width'  => '50px',
                'index'  => 'id',
            ));
        $this->addColumn('name',
            array(
                'header' => Mage::helper('vendor')->__('Name'),
                'width'  => '50px',
                'index'  => 'name',
            ));

        // $this->addColumn('sku',
        //     array(
        //         'header' => Mage::helper('vendor')->__('Sku'),
        //         'width'  => '50px',
        //         'index'  => 'sku',
        //     ));

        $this->addColumn('price',
            array(
                'header' => Mage::helper('vendor')->__('Price'),
                'width'  => '50px',
                'index'  => 'price',
            ));

        $this->addColumn('vendor_id',
            array(
                'header' => Mage::helper('vendor')->__('Vendor Id'),
                'width'  => '50px',
                'index'  => 'vendor_id',
            ));

        $this->addColumn('status',
            array(
                'header' => Mage::helper('vendor')->__('Status'),
                'width'  => '50px',
                'index'  => 'approve_status',
            ));
            
        $this->addColumn('type',
            array(
                'header' => Mage::helper('vendor')->__('Request Type'),
                'width'  => '50px',
                'index'  => 'request_type',
            ));
        
        $this->addColumn(
            'action',
            array(
                'header'   => Mage::helper('vendor')->__('Action'),
                'width'    => '50px',
                'type'     => 'action',
                'getter'   => 'getId',
                'actions'  => array(
                    array(
                        'caption' => Mage::helper('vendor')->__('APPROVE'),
                        'url'     => array(
                            'base' => '*/*/approve',
                        ),
                        'field'   => 'id',
                    ),
                    array(
                        'caption' => Mage::helper('vendor')->__('REJECT'),
                        'url'     => array(
                            'base' => '*/*/reject',
                        ),
                        'field'   => 'id',
                    ),

                ),
                'filter'   => false,
                'sortable' => false,
            )
        );

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'store' => $this->getRequest()->getParam('store'),
            'id'    => $row->getId())
        );
    }
}
