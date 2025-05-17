<?php

/**
    Template Name: Generic Floating Cart Trigger
    Template Type: woo-cart-template
*/


$model = \pockets::crud( 'woo/cart' )::initCached()->read( [
    'item_count' => "",
    "total" => []
] );

$cartID = 'floating-cart';

$query = json_encode( $model->get( 'query' ) );

printf(
    <<<'HTML'
        <pockets-woo-cart
            :query='%1$s'
            #default='cart'
            cart-id='%2$s'
            v-cloak
        >
            <i 
                @click='cart.api.toggle( cart.ID )' 
                class='fa fa-shopping-cart fs-20 d-flex gap-1 align-items-center'
                role='button'
            >
                <span class='fs-14'>{{ cart.results.item_count}}</span>
            </i>
        </pockets-woo-cart>
    HTML,
    $query,
    $cartID
);