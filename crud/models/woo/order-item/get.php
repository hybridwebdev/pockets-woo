<?php
namespace pockets_woo\crud\models\woo\order_item;
 
class get extends \pockets\crud\get_resource {
 
    function request_using_object() {
        return $this->resource;
    }

    function request_using_string(){
    }

    function request_using_integer(){
        
    }
    
}
