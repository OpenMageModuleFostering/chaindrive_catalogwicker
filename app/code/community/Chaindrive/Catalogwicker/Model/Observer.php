<?php
/**

 */
class Chaindrive_Catalogwicker_Model_Observer
{
    public function setInchooFilteredCategoryProductCollection()
    {
        
	if (Mage::app()->getRequest()->getControllerName() == 'category' && Mage::app()->getRequest()->getActionName() == 'view') {
		
		$products = Mage::app()->getLayout()
				->getBlockSingleton('Mage_Catalog_Block_Product_List')
				->getLoadedProductCollection()
				->getColumnValues('entity_id');

		Mage::getSingleton('core/session')
				->setInchooFilteredCategoryProductCollection($products);

		unset($products);
	}
	
	return $this;        
    }
}
