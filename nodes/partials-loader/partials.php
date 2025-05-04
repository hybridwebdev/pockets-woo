<?php 
namespace pockets_woo\nodes\partials_loader;

/**
    Shorthand helper that can be called to add new partials.
*/
class partials {

    use \pockets\traits\initOnce;

    static function register( $partial ){
                
        add_filter( node::$getAvailablePartials, function( array $list ) use( $partial ) {
            $list[] = $partial;
            return $list;
        } );

    }

}

partials::register( [

    'key' => 'single-product/add-to-cart',
    'title' => "Single Product / Add To Cart",
    'render' => function( $node ){

        global $product;
        $product = wc_get_product ( get_queried_object_id() );
        woocommerce_template_single_add_to_cart();

    }

] );

partials::register( [

    'key' => 'single-product/price',
    'title' => "Single Product Price",
    'render' => function( $node ){
        echo "single product price";
    }
    
] );

partials::register( [
    
    'key' => 'cart/notices-wrapper',
    'title' => "Notices wrapper",
    'render' => function( $node ){
        echo "Notices wrapper";
    }

] );