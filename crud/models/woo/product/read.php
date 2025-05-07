<?php
namespace pockets_woo\crud\models\woo\product;
 

class read extends \pockets\crud\resource_walker {
    
    use \pockets\crud\render;

    function image( array $read ) : \Wp_Error | array {
        //"https://place-hold.it/80x80"
        $image_id = get_post_thumbnail_id( $this->resource->get_id() ) ?? false;
        return \pockets::crud( 'image' )::init( $image_id )->read( $read );

    }
 
    function ID(){
        return $this->resource->get_id();
    }

    function title(){
        return $this->resource->get_name();
    }

    function sku(){
        return $this->resource->get_sku();
    }

    function price(){
        return $this->resource->get_price();
    }

    function parentID(){
        return $this->resource->get_parent_id();
    }

    function isVariation(){
        return $this->resource->is_type('variation');
    }

    /**
        Returns an object that can be used to add this product to the cart
        using wc()->cart->add_to_cart(). 
    */
    function addItem(){

        $isVariation = $this->isVariation();

        return [
            'quantity' => 1,
            'product_id' =>  $isVariation ? $this->parentID() : $this->ID(),
            'variation_id' => $isVariation ? $this->ID() : 0,
            'variation' => [],
            'cart_item_data' => []
        ];

    }

    function link( ?array $args = [ 'relative' => true ] ) : string {
        $link = get_the_permalink( $this->resource->get_id() );
        if( $args['relative'] ?? false === true) {
            return wp_make_link_relative( $link );
        }
        return $link;
    }

    function price_range( ?array $args = [] ){
        
        list(
            'format' => $format
        ) = wp_parse_args( ( $args ?? [] ), [
            'format' => true
        ]); 

        $formatter = fn( $price ) => $format ? wc_price( $price ) : $price; 

        if ( $this->resource->is_type( 'variable' ) ) {

            $min_price = $this->resource->get_variation_price( 'min' );  
            $max_price = $this->resource->get_variation_price( 'max' ); 
            
            return [
                'min' => $formatter( $min_price ),
                'max' => $formatter( $max_price )
            ];


        } 
        
        if ( !$this->resource->is_type( 'variable' ) ) {
            return [
                'min' => $formatter( $this->resource->get_price() ),
            ];
        }

    }

    function product_type(){
        return $this->resource->get_type();
    }

    /**
        This is wrong. 
    */
    function parentProduct( array $read ) : \WP_Error | array {
        
        if ( !$this->resource->is_type( 'variable' ) ) {
            return \pockets::error("This is not a variable product");
        }
        
        return \pockets::crud('woo/product')::init( $this->resource->get_id() )->read( $read );

    }

    function description(){
        return apply_filters( 'woocommerce_description', $this->resource->get_description() );
    }

    function short_description(){
        return apply_filters( 'woocommerce_short_description', $this->resource->get_short_description() );
    }
    
    function variationParent( $read ) {
        return \pockets::crud('woo/product')::init( $this->resource->get_parent_id() )->read( $read );
    }

}