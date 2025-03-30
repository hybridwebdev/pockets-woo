<?php
namespace pockets_woo\crud\models\woo\products;
 
class get extends \pockets\crud\get_resource {
 
    function request_using_object(){
        return $this->resource;
    }
 
    function request_using_array() {
        return new \Wp_Query( $this->resource );
    }

}
