<?php 
namespace pockets_woo\template_hooks;

class module {

    use \pockets\traits\init;

    function __construct(){
        
        single_product::init();
        checkout_form::init();
        
        add_filter( 'woocommerce_redirect_single_search_result', fn() => false );
 
    }

}
