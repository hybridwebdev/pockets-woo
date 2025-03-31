<?php

/**
    Template Name: Woo Generic Floating Cart
    Template Type: static-template
*/

$model = \pockets::crud( 'woo/cart' )::initCached()->read( [
    'total',
    'items' => [
        'render' => [
            'template' => "cart/floating-cart-item"
        ]
    ]
] );

?>

<pockets-woo-cart
    :query='<?= json_encode( $model->get( 'query' ) ) ?>'
    #default='{ results }'
>

    {{ results.total }}

    <render-html v-for='item in results.items' :innerHTML='item.render'>
    </render-html>

</pockets-woo-cart>
