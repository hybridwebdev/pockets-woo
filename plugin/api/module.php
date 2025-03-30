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

            \pockets::inject_data( $key , [
                'read' => $read,
                'results' => \pockets::crud('woo/cart')::init()->read( $read )
            ] );

            printf(
                <<<'T'
                <pockets-app>
                    <pockets-woo-cart
                        v-bind='%s'
                        #default='cart'
                    >
                        <render-html 
                            v-bind='cart.results'
                            :el='false'
                        ></render-html>
                    </pockets-woo-cart>
                </pockets-app>
                T,
                sprintf( '$pockets.data.%s', $key )
            );

        }

    }
    
}