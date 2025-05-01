<?php 
namespace pockets_woo\nodes;

class module {

    use \pockets\traits\init;

    function __construct(){
        
        floating_cart\trigger::init();
        floating_cart\cart_container::init();
        partials_loader\node::init();
    }


}
