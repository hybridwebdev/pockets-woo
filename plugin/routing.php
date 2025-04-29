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

        add_filter( 'body_class', function( $classes ) {

            return array_merge( $classes, array( 
                'woocommerce woocommerce-page woocommerce-js', 
                'woocommerce-cart',
                'woocommerce-checkout',
                'single-product'
            ) );
            
        } );


            add_action( 'wp_enqueue_scripts', function(){

                wp_enqueue_script( 'wc-cart' );
                wp_enqueue_script( 'wc-checkout' );
                wp_enqueue_script( 'wc-cart-fragments' );
                wp_enqueue_script( 'wc-single-product' );
                wp_enqueue_script( 'wc-add-to-cart-variation' );
                
            } );


        // if( !$routedWoo ) {
            
            /**
                Forces page to refresh instead of loading headlessly 
            */
             
            add_filter( 'pockets-node-tree/router/routes', fn( $routes ) => array_merge(
                $routes,
                [
                    [
                        'path' => sprintf( "%s:catchAll(.*)", "/product")
                    ],
                    [
                        'path' => sprintf( 
                            "%s:catchAll(.*)", 
                            untrailingslashit(
                                wp_make_link_relative( 
                                    wc_get_cart_url() 
                                ) 
                            )
                        )
                    ],
                     [
                        'path' => sprintf( 
                            "%s:catchAll(.*)", 
                            untrailingslashit(
                                wp_make_link_relative( 
                                    wc_get_checkout_url() 
                                ) 
                            )
                        )
                    ],
                ]
            ) );

        // }

    }
    
}
