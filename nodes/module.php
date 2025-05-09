<?php 
namespace pockets_woo\nodes;

class module {

    use \pockets\traits\init;

    function __construct(){
        
        product_partials_loader\node::init();
        cart_partials_loader\node::init();
        
    }


}
