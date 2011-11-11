<?php
class Narfstudios_WishlistExtend_Model_Observer {
    
    public function addWishlistProductToSession($observer) {
       	//Changed objects because event changed
		$_request = $observer->getControllerAction()->getRequest();
        $_product = $observer->getControllerAction()->getRequest()->getParam('product');

        // add the combination of wishlist and product to session
        $code = $_request->getParam('wishlist_code');

        if(!empty($code)){
            // prepare session entry for every combination
            $array =  Mage::getSingleton('checkout/session')->getProductFromOtherWishlistCodeAdded();
            $array[] = $code.'@_@'.$_product;
            Mage::getSingleton('checkout/session')->setProductFromOtherWishlistCodeAdded($array);
        }
    }
    
    /**
     * Called after checkout_onepage_controller_success_action to delete
     * the product was added from a wishlist
     * @author Manuel Neukum
     * @param type $event 
     */
    public function removeProductFromWishlist($observer) 
    {

        $event = $observer->getEvent();
        $order = $event->getOrder();
        
        // remove from wishlist
        $session = Mage::getSingleton('checkout/session');
        $code_array = $session->getProductFromOtherWishlistCodeAdded();
		
		    	Mage::log('call removeProductFromWishlist', null, 'wishlist.log');  
		
		Mage::log($code_array, null, 'wishlist.log');  
		
        if(!empty($code_array)) {
            
            // for every wishlist product combination we have to check if there is an order item
            foreach($code_array as $i => $code){
                $code_combination = explode('@_@', $code);
                $wishlist_code = $code_combination[0];
                $product_id = $code_combination[1];
                $wishlist = Mage::getModel('wishlist/wishlist')->loadByCode($wishlist_code);
                
                //wishlist found look for product
                foreach ($wishlist->getItemCollection() as $index => $item) {
                    if($item->getProductId() == $product_id) {
                        // delete from wishlist
                        $item->delete();

                        // delete from session
                        unset($code_array[$i]);
                        $session->setProductFromOtherWishlistCodeAdded($code_array);
                    }
                }
            }          
        }
    }
}
?>
