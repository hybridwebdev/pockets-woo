<?php
namespace pockets_woo\crud\models\woo\order_item;

class read extends \pockets\crud\resource_walker {

    function meta( string $key ) : mixed {
       
        return $this->resource->get_meta( $key );

    }
    
}