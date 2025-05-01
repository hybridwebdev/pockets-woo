<?php
namespace pockets_woo\plugin;

#[\AllowDynamicProperties]
class routing {

    use \pockets\traits\initOnce;

    function __construct(){
        
        $this->apply_woo_routing();

    
        add_filter( 'woocommerce_locate_template', function( $template, $template_name, $template_path ){

            $path = sprintf( "%s/%s/%s", \pockets_woo\base::init()->dir, 'templates/woocommerce',  $template_name);

            $debug = fn( $color ) => sprintf("<div class='p-4 %s'><p>%s</p><p>%s</p><p>%s</p> </div>", $color, $path, $template_path, $template_name);

            if( file_exists($path) ){
                //echo $debug('bg-black text-white');
                return $path;
            }

            //echo $debug('bg-primary text-white');

            return $template;
            
        }, 10, 3 );

    }

    function apply_woo_routing(){

        $routedWoo = \pockets\woo::getOptions( 'apply-routing-handler' );

        add_action( 'wp_enqueue_scripts', function(){
            wp_enqueue_style ( 'woocommerce-general' );
            wp_enqueue_style ( 'woocommerce-layout' );
            wp_enqueue_style ( 'woocommerce-smallscreen' );
        });

        add_filter( "pockets/vue/app.js/dependencies", function( array $dependencies ){

            return array_merge( $dependencies, [
                'wc-add-to-cart-variation',
                'wc-checkout',
                'wc-cart-fragments',
                'wc-cart',
                //'wc-single-product' 
            ] );
            
        } );


        // if( !$routedWoo ) {
            
            /**
                Forces page to refresh instead of loading headlessly 
            */
             
            add_filter( 'pockets-node-tree/router/routes', fn( $routes ) => array_merge(
                $routes,
                [
                    // [
                    //     'path' => sprintf( "%s:catchAll(.*)", "/product")
                    // ],
                    // [
                    //     'path' => sprintf( 
                    //         "%s:catchAll(.*)", 
                    //         untrailingslashit(
                    //             wp_make_link_relative( 
                    //                 wc_get_cart_url() 
                    //             ) 
                    //         )
                    //     )
                    // ],
                    // [
                    //     'path' => sprintf( 
                    //         "%s:catchAll(.*)", 
                    //         untrailingslashit(
                    //             wp_make_link_relative( 
                    //                 wc_get_checkout_url() 
                    //             ) 
                    //         )
                    //     )
                    // ],
                ]
            ) );

        // }

    }
    
}
