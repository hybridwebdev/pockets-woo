<?php 
namespace pockets_woo\template_hooks;

class validation {

    use \pockets\traits\init;

    function __construct(){
       
        add_filter('woocommerce_update_cart_validation', function($passed, $cart_item_key, $cart_item, $quantity) {

            if ($cart_item['data']->is_sold_individually() && $quantity > 1) {

                $product = $cart_item['data']; // WooCommerce product object
                $product_name = $product->get_name(); // Get the product name
            
                wc_add_notice( sprintf('You cannot add another "%s" to your cart!', $product_name), 'error' );

                return false;
                
            }

            return $passed;

        }, 10, 4);

    }
}