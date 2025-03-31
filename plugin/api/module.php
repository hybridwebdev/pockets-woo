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

            $model = \pockets::crud( 'woo/cart' )::initCached()->read( [
                'render:innerHTML' => [
                    'template' => "cart/generic-floating-cart"
                ],
            ] );
            
            printf(
                <<<'T'
                <pockets-app>

                    <pockets-woo-cart
                        :query='%s'
                        #default='cart'
                    >

                        <render-html 
                            v-bind='cart.results'
                            :el='false'
                        ></render-html>

                    </pockets-woo-cart>

                </pockets-app>
                T,
                json_encode( $model->get('query') ),
            );

        }

    }
    
}