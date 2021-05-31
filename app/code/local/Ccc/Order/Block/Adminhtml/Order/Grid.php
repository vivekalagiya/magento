<?php

class Ccc_Order_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _getCollectionClass()
    {
        return 'order/order_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        // echo '<pre>';
        // print_r($collection->getData());
        // die;
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'order_id',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('order')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('customer_name', array(
            'header' => Mage::helper('order')->__('Bill to Name'),
            'index' => 'customer_name',
        ));

        // $this->addColumn('shipping_name', array(
        //     'header' => Mage::helper('order')->__('Ship to Name'),
        //     'index' => 'shipping_name',
        // ));

        $this->addColumn('total', array(
            'header' => Mage::helper('order')->__('Total'),
            'index' => 'total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('discount', array(
            'header' => Mage::helper('order')->__('Discount'),
            'index' => 'discount',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));

        // $this->addColumn('status', array(
        //     'header' => Mage::helper('order')->__('Status'),
        //     'index' => 'status',
        //     'type'  => 'options',
        //     'width' => '70px',
        //     'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        // ));

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action',
                array(
                    'header'    => Mage::helper('sales')->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View'),
                            'url'     => array('base'=>'*/sales_order/view'),
                            'field'   => 'order_id',
                            'data-column' => 'action',
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
            ));
        }
        $this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        // if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
        //     return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        // }
        // return $this->getUrl('*/*/grid', ['order_id' => $row->getId()]);
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

}
