<?php
class Narfstudios_WishlistExtend_Helper_Data extends Mage_Checkout_Helper_Cart
{
    /**
     * Change line to add wishlist code in link
     * @param type $product
     * @param type $additional
     * @return type 
     */
    public function getAddUrl($product, $additional = array())
    {
        $continueUrl    = Mage::helper('core')->urlEncode($this->getCurrentUrl());
        $urlParamName   = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;

        $routeParams = array(
            $urlParamName   => $continueUrl,
            'product'       => $product->getEntityId()
        );

        if (!empty($additional)) {
            $routeParams = array_merge($routeParams, $additional);
        }

        // #narf add code
        $code = $this->_getRequest()->getParam('code');
        if(!empty($code)) {
            $routeParams['wishlist_code'] = $code;
        }
        
        if ($product->hasUrlDataObject()) {
            $routeParams['_store'] = $product->getUrlDataObject()->getStoreId();
            $routeParams['_store_to_url'] = true;
        }

        if ($this->_getRequest()->getRouteName() == 'checkout'
            && $this->_getRequest()->getControllerName() == 'cart') {
            $routeParams['in_cart'] = 1;
        }

        return $this->_getUrl('checkout/cart/add', $routeParams);
    }
}
?>
