<?php

/**
    Template Name: Full Page Cart
    Template Type: woo-cart-template
*/

$model = \pockets::crud( 'woo/cart' )::initCached()->read( [
    'subtotal',
    'total',
    'items' => [
        'render:innerHTML' => [
            'template' => "woo-cart-partials/cart-item-columns"
        ]
    ]
] );

?>

<pockets-woo-cart

    :query='<?= json_encode( $model->get( 'query' ) ) ?>'
    cart-id='full-page-cart'
    #default='cart'
     
>

    <div 
        class='grid columns-1 gap-1 loading-container'
        style='grid-template-rows: auto 1fr auto;'
        :loading='cart.api.busy || cart.isLoading'
    >
         
        <div 
            v-if='cart.results.items'
        >
            <div v-if='cart.results.items.length == 0' class='grid columns-1 gap-1 text-center p-4 bg-white'>
                <p>There are no items in your cart.</p>
                <a href='/shop' class='btn btn-outline-accent-dk px-4 p-1 mx-auto'>View Products</a>
            </div>

            <div class='grid columns-1 gap-1' v-if='cart.results.items.length > 0'>
                
                <div class='cart-item-column-layout cart-item-column-layout-header fw-8'>
                    <div></div>
                    <div>Product</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Total</div>
                </div>

                <render-html v-for='item in cart.results.items' v-bind='item'></render-html>

            </div>

        </div>

        <div class='p-2 bg-grey-800 text-white grid align-items-center columns-1 gap-1 fs-20 col-xs-12 col-lg-6 ms-auto'>
            <div class='border-5 border-bottom border-grey-md pb-1'>
                <div class='grid-info-160 gap-1'>
                    <span>Subtotal</span> 
                    {{ cart.results.subtotal }}
                </div>
                <div class='grid-info-160 gap-1'>
                    <span>Total</span> 
                    {{ cart.results.total }}
                </div>
            </div>
            <div class='d-flex gap-1 text-center'>
                <a href='/checkout' class='px-6 py-1 justify-content-center btn btn-confirm text-white d-flex align-items-center gap-1 col-12'>
                    <i class="fa-solid fa-cash-register"></i>
                    Checkout
                </a>
            </div>
        </div>
    </div>

</pockets-woo-cart>