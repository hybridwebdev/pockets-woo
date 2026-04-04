<?php 
namespace pockets_woo\template_hooks;

class validation {

    use \pockets\traits\init;

    function __construct(){
       
        add_filter('woocommerce_update_cart_validation', function($passed, $cart_item_key, $cart_item, $quantity) {

            if ($cart_item['data']->is_sold_individually() && $quantity > 1) {

                wc_add_notice('Only 1 allowed per item.', 'error');

                return false;
                
            }

            return $passed;

        }, 10, 4);
    }
}