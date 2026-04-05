<?php 
namespace pockets_woo\template_hooks;

class module {

    use \pockets\traits\init;

    function __construct(){
        
        single_product::init();
        checkout_form::init();
        global_cleanup::init();
        validation::init();
        
        add_filter( 'woocommerce_redirect_single_search_result', fn() => false );

        add_action('wp_footer', fn() => printf( 
            "<pockets-app>%s</pockets-app>",
            \pockets::load_template( [ 'template' => "woo-cart-partials/notices" ] ) 
        ), 1 );;

    }

}
