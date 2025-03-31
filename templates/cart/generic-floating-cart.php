<?php

/**
    Template Name: Woo Generic Floating Cart
    Template Type: static-template
*/

$model = \pockets::crud( 'woo/cart' )::initCached()->read( [
    'total',
    'items' => [
        'render:innerHTML' => [
            'template' => "cart/floating-cart-item"
        ]
    ]
] );

?>

<pockets-woo-cart
    :query='<?= json_encode( $model->get( 'query' ) ) ?>'
    #default='{ results, api }'
>

    <div class='grid columns-1 gap-2 loading-container' :loading='$pockets.woo.cart.busy'>
        
        Cart Total ${{ results.total }}

        <div>
            <render-html v-for='item in results.items' v-bind='item'>
            </render-html>
        </div>

    </div>

</pockets-woo-cart>
