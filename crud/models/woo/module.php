<?php 
namespace pockets_woo\crud\models\woo;

class module {
    
    use \pockets\traits\init;

    function __construct(){
        
        cart\model::register();
        cart_item\model::register();
        products\model::register();
        product\model::register();
        product_variation\model::register();
        order\model::register();
        order_item\model::register();
        data\model::register();

    }

}