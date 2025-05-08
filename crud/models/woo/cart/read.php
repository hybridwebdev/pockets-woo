<?php
namespace pockets_woo\crud\models\woo\cart;

class read extends \pockets\crud\resource_walker {

    use \pockets\crud\render;
    
    function items( array $read ) : array {
        
        $values = array_map(
            array: $this->resource->cart_contents ?? [],
            callback: fn( $item ) => \pockets::crud('woo/cart/item')::init( $item )->read( $read )
        );

        return array_values( $values);
        
    }

    function subtotal( ?array $args ){
        return \pockets\woo::wc_price( $this->resource->get_subtotal('raw'), $args );
    }
    
    function total( ?array $args ){
        return \pockets\woo::wc_price( $this->resource->get_total('raw'), $args );
    }

    function taxes() : array {
        return $this->resource->get_taxes();
    }

    function item_count(){
        return count($this->resource->cart_contents);
    }
    
}