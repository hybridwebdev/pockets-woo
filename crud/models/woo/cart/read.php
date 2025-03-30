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

    function subtotal(){
        return $this->resource->get_subtotal();
    }
    
    function total(){
        return $this->resource->get_total('raw');
    }

    function tax(){
        return $this->resource->get_taxes();
    }

}