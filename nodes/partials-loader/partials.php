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

/**
    Single Product partials
*/
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

    'key' => 'single-product/description',
    'title' => "Single Product Description",
    'render' => function( $node ){
        
        $product = get_queried_object();

        $data = \pockets::crud('woo/product')::init( $product )->read( [
            'render' => [
                'template' => 'single-product/description'
            ]
        ] );
        
        echo $data['render'];

    }
    
] );


partials::register( [

    'key' => 'single-product/main-image',
    'title' => "Single Product / Main Image",
    'render' => function( $node ){
        
        $product = get_queried_object();

        $data = \pockets::crud('woo/product')::init( $product )->read( [
            'render' => [
                'template' => 'single-product/main-image'
            ]
        ] );
        
        echo $data['render'];

    }
    
] );

partials::register( [

    'key' => 'single-product/price',
    'title' => "Single Product Price",
    'render' => function( $node ){
        
        $product = get_queried_object();

        $data = \pockets::crud('woo/product')::init( $product )->read( [
            'render' => [
                'template' => 'single-product/price'
            ]
        ] );
        
        echo $data['render'];

    }
    
] );

/**
    Cart partials
*/

partials::register( [
    
    'key' => 'cart/notices-wrapper',
    'title' => "Notices wrapper",
    'render' => function( $node ){
        echo "Notices wrapper";
    }

] );