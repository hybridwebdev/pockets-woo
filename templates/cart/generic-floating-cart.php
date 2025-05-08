<?php

/**
    Template Name: Woo Generic Floating Cart
    Template Type: static-template
*/

$model = \pockets::crud( 'woo/cart' )::initCached()->read( [
    'subtotal',
    'items' => [
        'render:innerHTML' => [
            'template' => "cart/cart-item-compact"
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
            class='floating-cart-container bg-white text-black d-grid gap-0 loading-container shadow-menu'
            style='grid-template-rows: auto 1fr auto;'
            :loading='cart.api.busy'
        >
            <div class='bg-grey-800 text-white d-flex align-items-center ps-2  fs-20 '>
                <span>Cart</span>
                <button @click='cart.close' class='btn btn-grey-700 ms-auto rounded-0'>
                    <i class='fa fa-times'></i>
                </button>
            </div>
            <div 
                class='p-2 bg-grey-100'
                style='overflow-y: scroll;'
                v-if='cart.results.items'
            >
                <div v-if='cart.results.items.length == 0' class='grid columns-1 gap-1 text-center'>
                    <p>There are no items in your cart.</p>
                    <a href='/shop' class='btn btn-accent-dk px-4 p-1 mx-auto'>View Products</a>
                </div>
                <div class='grid columns-1 bg-grey-100 gap-1' v-if='cart.results.items.length > 0'>
                    <render-html v-for='item in cart.results.items' v-bind='item'>
                    </render-html>
                </div>
            </div>

            <div class='p-2 bg-grey-800 text-white grid align-items-center columns-1 gap-1 fs-20'>
                <div class='border-5 border-bottom border-grey-md pb-1'>
                    <div class='grid-info gap-1'>
                        <span>Subtotal</span> 
                        {{ cart.results.subtotal }}
                    </div>
                </div>
                <div class='grid columns-2 gap-1 text-center'>
                    <a href='/cart' class='justify-content-center btn btn-grey-700 text-white rounded-0 d-flex align-items-center gap-1'>
                        <i class='fa fa-shopping-cart'></i>
                        Cart
                    </a>
                    <a href='/checkout' class='justify-content-center btn btn-confirm text-white rounded-0 d-flex align-items-center gap-1'>
                        <i class="fa-solid fa-cash-register"></i>
                        Checkout
                    </a>
                </div>
            </div>
        </div>

    </div>

</pockets-woo-cart>