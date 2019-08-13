<?php

/**
 * Product controller
 *
 * @category   Chaindrive
 * @package    Chaindrive_Catalogwicker
 */
//include'Mage/Catalog/controllers/ProductController.php';
class Chaindrive_Catalogwicker_ProductController extends Mage_Core_Controller_Front_Action {

    protected function _initProduct() {
        Mage::dispatchEvent('catalog_controller_product_init_before', array('controller_action' => $this));

        $productId = (int) $this->getRequest()->getParam('pid');



        $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);

        Mage::register('current_product', $product);
        Mage::register('product', $product);

        Mage::dispatchEvent('catalog_controller_product_init', array('product' => $product));
        Mage::dispatchEvent('catalog_controller_product_init_after', array('product' => $product, 'controller_action' => $this));


        return $product;
    }

    protected function _initProductLayout($product) {


        $update = $this->getLayout()->getUpdate();
        $update->addHandle('default');


        $update->addHandle('PRODUCT_TYPE_' . $product->getTypeId());
        $update->addHandle('PRODUCT_' . $product->getId());

        $this->addActionLayoutHandles();

        $this->loadLayoutUpdates();

        $update->addUpdate($product->getCustomLayoutUpdate());

        $update->merge(strtolower($this->getFullActionName()) . '_FINAL');

        $this->generateLayoutXml()->generateLayoutBlocks();


        return $this;
    }

    public function loadgroupproductsAction() {
        $data = $this->getRequest()->getParam('pid');

        if ($product = $this->_initProduct()) {
            Mage::dispatchEvent('catalog_controller_product_view', array('product' => $product));

            Mage::getSingleton('catalog/session')->setLastViewedProductId($product->getId());
            Mage::getModel('catalog/design')->applyDesign($product, Mage_Catalog_Model_Design::APPLY_FOR_PRODUCT);

            $this->_initProductLayout($product);
            //$this->loadLayout(); 
            $this->renderLayout();
        } else {
            if (isset($_GET['store']) && !$this->getResponse()->isRedirect()) {
                $this->_redirect('');
            } elseif (!$this->getResponse()->isRedirect()) {
                $this->_forward('noRoute');
            }
        }
    }

}
