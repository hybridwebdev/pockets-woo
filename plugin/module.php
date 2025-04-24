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
            Force woo to fully load in crud rest request
        */
        add_filter( 'woocommerce_is_rest_api_request', function( bool $is_request ){

            if(
                \pockets\crud\end_point\module::is_endpoint_url( $_SERVER['REQUEST_URI'] )
            ) {
                return false;
            };
 
            return $is_request;

        });


    }
    
}
