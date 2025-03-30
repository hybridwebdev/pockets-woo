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

        static function renderCart(){
            
            $read = [
                'render:innerHTML' => [
                    'template' => "cart/generic-floating-cart"
                ],
            ];

            $key = uniqid('wooCart');

            $results = \pockets::crud('woo/cart')::init()->read( $read );
            \pockets::inject_data( $key , [
                'read' => $read,
                'results' => $results
            ] );

            printf(
                <<<'T'
                <pockets-app>
                    <pockets-woo-cart
                        v-bind='%s'
                        #default='cart'
                    >
                        %s
                    </pockets-woo-cart>
                </pockets-app>
                T,
                sprintf( '$pockets.data.%s', $key ),
                $results['innerHTML']
            );

        }

    }
    
}