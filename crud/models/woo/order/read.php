<?php
namespace pockets_woo\crud\models\woo\order;

class read extends \pockets\crud\resource_walker {

    function ID() : int {
       
        return $this->resource->get_id();

    }
    
}