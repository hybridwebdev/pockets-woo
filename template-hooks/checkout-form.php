<?php 
namespace pockets_woo\template_hooks;

class checkout_form {

    use \pockets\traits\init;

    function __construct(){
        
        // add_filter( 'woocommerce_checkout_cart_item_quantity', function($quantity_html, $cart_item, $cart_item_key){

        //     return sprintf(
        //         <<<HTML
        //             <strong class="product-quantity">%s</strong>
        //         HTML,
        //         $cart_item['quantity']
        //     );
        // }, 10, 3 );
        
    }


}
