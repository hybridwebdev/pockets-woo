<?php
namespace pockets_woo\crud\models\woo\products;

class read extends \pockets\crud\resource_walker {

     function items( array $read ) : array {
        return array_map( 
            array: $this->resource->posts ?? [],
            callback: fn( $post ) => \pockets::crud( 'woo/product' )::init( $post )->read( $read ), 
        );
    }

}