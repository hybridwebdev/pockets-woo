<?php
namespace pockets_woo\plugin\api {

    class module {
        /**
            Dummy module so that the namespace below can be bootloaded.
        */
        static function init(){}
    }

}

namespace pockets {
    
    class woo {

        use \pockets\traits\init;

    }
    
}