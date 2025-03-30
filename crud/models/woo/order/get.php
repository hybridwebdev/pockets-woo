<?php
namespace pockets_woo\crud\models\woo\order;
 
class get extends \pockets\crud\get_resource {
 
    function request_using_object() {
        return $this->resource;
    }

    function request_using_string(){
        return wc_get_order( $this->resource );
    }

    function request_using_integer(){
        return wc_get_order( $this->resource );
    }
    
}
