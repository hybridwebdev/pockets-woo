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
    cart-id='floating-cart'
    #default='cart'
     
>

    <div 
        class='floating-cart bg-black bg-opacity-50' 
        :open='cart.isOpen'
        @click.self="cart.close"
    >
        <div 
            class='floating-cart-container bg-white text-black d-grid gap-0 loading-container'
            style='grid-template-rows: auto 1fr auto;'
            :loading='cart.api.busy'
        >
            <div class='bg-accent-dk text-white d-flex align-items-center ps-2'>
                <span>Cart</span>
                <button @click='cart.close' class='btn btn-accent-dk fs-20 ms-auto rounded-0'>
                    <i class='fa fa-times'></i>
                </button>
            </div>
            <div 
                class='px-2 py-4'
                style='overflow-y: scroll;'
            >
                <div class='grid columns-1 gap-1'>
                    <render-html v-for='item in cart.results.items' v-bind='item'>
                    </render-html>
                </div>
            </div>
            <div class='p-2 bg-accent-dk text-white d-flex align-items-center'>
                Total ${{ cart.results.total }}
                <a href='/checkout' class='ms-auto btn btn-primary-dk text-white rounded-0'>
                    Checkout
                </a>
            </div>
        </div>

    </div>

</pockets-woo-cart>