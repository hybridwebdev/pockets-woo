<?php
namespace pockets_woo\plugin;

#[\AllowDynamicProperties]
class routing {

    use \pockets\traits\initOnce;

    function __construct(){
        
        $this->apply_woo_routing();
    
    }

    function apply_woo_routing(){

        $routedWoo = \pockets\woo::getOptions( 'apply-routing-handler' );

        add_action( 'wp_enqueue_scripts', function(){
            wp_enqueue_style ( 'woocommerce-general' );
            wp_enqueue_style ( 'woocommerce-layout' );
            wp_enqueue_style ( 'woocommerce-smallscreen' );
        });

        add_filter( "pockets/vue/app.js/dependencies", function( array $dependencies ){

            /**
                Only load on front end 
            */
            if( is_admin() ) {
                return $dependencies;
            }

            return array_merge( $dependencies, [
                'wc-add-to-cart-variation',
                // 'wc-cart-fragments',
                // 'wc-single-product',
                // 'wc-checkout',
                // 'wc-cart',
            ] );
            
        } );


        // if( !$routedWoo ) {
            
            /**
                Forces page to refresh instead of loading headlessly 
            */
             
            add_filter( 'pockets-node-tree/router/routes', fn( $routes ) => $routes::add( [
                'path' => sprintf( 
                    "%s:catchAll(.*)", 
                    untrailingslashit(
                        wp_make_link_relative( 
                            wc_get_checkout_url() 
                        ) 
                    )
                )
            ], true ) );

        // }

    }
    
}
