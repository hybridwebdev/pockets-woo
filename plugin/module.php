<?php
namespace pockets_woo\plugin;

/**
    Bootloader for Pockets Form extension
*/

#[\AllowDynamicProperties]
class module extends \pockets\base {

    use \pockets\traits\initOnce;

    function __construct(){
        
        parent::__construct();

        api\module::init();
        \pockets_woo\crud\models\woo\module::init();
        \pockets_woo\nodes\module::init();
        route_filters::init();

        /**
            Force woo to fully load in rest request 
        */
        add_filter( 'woocommerce_is_rest_api_request', fn() => false );


    }
    
}
