<?php

class Ccc_Browse_Block_Adminhtml_Browse_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('browseGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        // $this->setUseAjax(true);
        // $this->setVarNameFilter('browse_filter');
    }

    public function _prepareCollection()
    {
        $collection = Mage::getModel('browse/browse')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('quantity');
            
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            
        $collection->joinAttribute(
            'name',
            'browse/name',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $collection->joinAttribute(
            'sku',
            'browse/sku',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'price',
            'browse/price',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'quantity',
            'browse/quantity',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $collection->joinAttribute(
            'id',
            'browse/entity_id',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('browse')->__('id'),
                'width'  => '50px',
                'index'  => 'id',
            ));
        $this->addColumn('name',
            array(
                'header' => Mage::helper('browse')->__('Name'),
                'width'  => '50px',
                'index'  => 'name',
            ));

        $this->addColumn('sku',
            array(
                'header' => Mage::helper('browse')->__('Sku'),
                'width'  => '50px',
                'index'  => 'sku',
            ));

        $this->addColumn('price',
            array(
                'header' => Mage::helper('browse')->__('Price'),
                'width'  => '50px',
                'index'  => 'price',
            ));

        $this->addColumn('quantity',
            array(
                'header' => Mage::helper('browse')->__('Quantity'),
                'width'  => '50px',
                'index'  => 'quantity',
            ));

        $this->addColumn('action',
            array(
                'header'   => Mage::helper('browse')->__('Action'),
                'width'    => '50px',
                'type'     => 'action',
                'getter'   => 'getId',
                'actions'  => array(
                    array(
                        'caption' => Mage::helper('browse')->__('Delete'),
                        'url'     => array(
                            'base' => '*/*/delete',
                        ),
                        'field'   => 'id',
                    ),
                ),
                'filter'   => false,
                'sortable' => false,
            ));

        parent::_prepareColumns();
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/index', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'store' => $this->getRequest()->getParam('store'),
            'id'    => $row->getId())
        );
    }



}


?>