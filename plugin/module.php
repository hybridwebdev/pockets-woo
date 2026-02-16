<?php
namespace pockets_woo\plugin;

/**
    Bootloader for Plugin
*/

#[\AllowDynamicProperties]

class module extends \pockets\base {

    use \pockets\traits\initOnce;

    function __construct(){
        
        parent::__construct();

        api\module::init();
        \pockets_woo\crud\models\woo\module::init();
        \pockets_woo\nodes\module::init();
        \pockets_woo\template_hooks\module::init();
        update\register_updater::init();
        route_filters::init();
        routing::init();

        /**
            Overrides woos locate template logic to use pockets internal locate template logic instead. 
        */
        add_filter( 'woocommerce_locate_template', function( $template, $template_name, $template_path ){

            /**
                pop .php off end of file path
            */
            $path = substr( $template_name, 0, -4 ); 

            $path = \pockets::locate_template( sprintf( "/woocommerce/%s", $path ) );;

            if( file_exists( $path ) ){
                return $path;
            }

            return $template;
            
        }, 10, 3 );

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

        } );

        \pockets::inject_data('woo', [
            'options' => \pockets\woo::getOptions()
        ] );

    }
 
}
