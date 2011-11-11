<?php
class Narfstudios_WishlistExtend_Helper_Wishlist extends Mage_Wishlist_Helper_Data
{
    
    public function getSharedAddToCartUrl($item)
    {
        $continueUrl  = Mage::helper('core')->urlEncode(Mage::getUrl('*/*/*', array(
            '_current'      => true,
            '_use_rewrite'  => true,
            '_store_to_url' => true,
        )));

        $urlParamName = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
        $params = array(
            'item' => is_string($item) ? $item : $item->getWishlistItemId(),
            $urlParamName => $continueUrl
        );

        // #narf add code
        $code = $this->_getRequest()->getParam('code');
        if(!empty($code)) {
            $params['wishlist_code'] = $code;
        }

        return $this->_getUrlStore($item)->getUrl('wishlist/shared/cart', $params);
    }
}