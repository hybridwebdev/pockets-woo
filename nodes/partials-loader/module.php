<?php 
namespace pockets_woo\nodes\partials_loader;

class module {

    use \pockets\traits\init;

    function __construct(){
        /**
            Partials needs to load first so it can add its filters to then node partials list.
        */
        partials::init();
        node::init();
    }

}
