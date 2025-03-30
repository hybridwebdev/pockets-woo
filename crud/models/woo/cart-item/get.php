<?php
namespace pockets_woo\crud\models\woo\cart_item;
 
class get extends \pockets\crud\get_resource {
     
    function request_using_array(){
        return (object)$this->resource;
    }

}
