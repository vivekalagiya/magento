<?php
class Ccc_Custom_Block_Adminhtml_Custom_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('CustomGrid');
        $this->setDefaultSort('Custom_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_custom/data')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(   
            'Custom_id',
            array(
                'header' => Mage::helper('custom')->__('ID'),
                'align' => 'left',
                'type' => 'number',
                'width' => '50px',
                'index' => 'Custom_id'
            )
        );

        $this->addColumn(
            'first_name',
            array(
                'header' => Mage::helper('custom')->__('First Name'),
                'align' => 'left',
                'width' => '50px',
                'index' => 'first_name'
            )
        );
        $this->addColumn(
            'last_name',
            array(
                'header' => Mage::helper('custom')->__('Last Name'),
                'align' => 'left',
                'width' => '50px',
                'index' => 'last_name'
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
