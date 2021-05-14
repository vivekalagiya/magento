<?php

class Ccc_Browse_Model_Resource_Browse_Attribute_Collection extends Mage_Eav_Model_Resource_Entity_Attribute_Collection
{

    protected function _initSelect()
    {
        $this->getSelect()->from(array('main_table' => $this->getResource()->getMainTable()))
            ->where('main_table.entity_type_id=?', Mage::getModel('eav/entity')->setType(Ccc_Browse_Model_Resource_Browse::ENTITY)->getTypeId())
            ->join(
                array('additional_table' => $this->getTable('browse/eav_attribute')),
                'additional_table.attribute_id = main_table.attribute_id'
            );
        return $this;
    }

    public function setEntityTypeFilter($typeId)
    {
        return $this;
    }
}
