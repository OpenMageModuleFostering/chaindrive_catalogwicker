<?php
/*
 */
class Chaindrive_Catalogwicker_Block_Links extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('chaindrivecatalog/links.phtml');
    }
    
    /**
     * @return Mage_Catalog_Model_Product
     */
    public function getPreviousProduct()
    {
        return $this->helper('chaindrive_catalogwicker')->getPreviousProduct();
    }

    /**
     * @return Mage_Catalog_Model_Product
     */
    public function getNextProduct()
    {
        return $this->helper('chaindrive_catalogwicker')->getNextProduct();
    }    
}
