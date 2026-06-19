<?php 
namespace pockets_woo\nodes;

class module {

    use \pockets\traits\init;

    function __construct(){
        
        if( class_exists('\pockets_node_tree') ) {
            product_partials_loader\node::init();
            cart_partials_loader\node::init();
            shop_partials_loader\node::init();
        }
        
    }


}
