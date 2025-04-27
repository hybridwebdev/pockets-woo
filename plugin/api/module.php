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

        static function getOptions( string $key = 'all' ) {
            
            $options = [
                /**
                    If set to true, a bunch of behavior is modified to allow
                    woo to work with headless router
                */
                'apply-routing-handler' => false
            ];

            return match( $key ) {
                'all' => $options,
                default => $options[$key] ?? null
            };
        }

    }
    
}