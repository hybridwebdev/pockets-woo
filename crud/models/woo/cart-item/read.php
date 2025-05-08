<?php
namespace pockets_woo\crud\models\woo\cart_item;

class read extends \pockets\crud\resource_walker {
    
    use \pockets\crud\render;
    
    /**
        This is the unique hash Woo uses to connect a cart item to its data.
    */
    function key(){
        return $this->resource->key;
    }
    
    function quantity(){
        return $this->resource->quantity;
    }

    function product( array $read ){
        return \pockets::crud( 'woo/product' )::init( $this->resource->product_id )->read( $read );
    }
    
    function variation( array $read ){
        return \pockets::crud( 'woo/product' )::init( $this->resource->variation_id )->read( $read );
    }

    function item_info( array $read ){
        
        if( $this->resource->variation_id == 0 ) {
            return $this->product( $read );
        }

        return $this->variation( $read );

    }

    function subtotal( ?array $args ){
        return \pockets\woo::wc_price( $this->resource->line_subtotal, $args );
    }
    
    function total( ?array $args ){
        return \pockets\woo::wc_price( $this->resource->line_total, $args );
    }
    
}