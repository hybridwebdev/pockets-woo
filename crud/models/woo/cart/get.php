<?php
namespace pockets_woo\crud\models\woo\cart;
 
class get extends \pockets\crud\get_resource {
    
    public string $default_array_by = 'null';

    function __getCart(){

        if ( is_null( WC()->cart ) ) {
            wc_load_cart();
            WC()->cart->get_cart_from_session();
        }

        return WC()->cart;

    }

    function request_using_object(){
        return $this->__getCart();
    }

    function request_using_string(){
        return $this->__getCart();
    }

    function request_using_integer(){
        return $this->__getCart();
    }

    function request_using_null() {
        return $this->__getCart();
    }
    
    function array_by_null(){
        return $this->__getCart();  
    }

}
