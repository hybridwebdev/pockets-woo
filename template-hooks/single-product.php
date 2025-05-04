<?php 
namespace pockets_woo\template_hooks;

class single_product {

    use \pockets\traits\init;

    function __construct(){
        
        /**
            Remove the container that woo adds to add-to-cart/variable 
            that shows the variation price/description. 
        */
        remove_action( "woocommerce_single_variation", "woocommerce_single_variation", 10 );

    }


}
