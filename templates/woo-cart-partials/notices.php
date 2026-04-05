<?php

/**
    Template Name: Woo Cart Notices
    Template Type: woo-cart-template
*/

// wc_add_notice("teeeeeeeeeeeeest", "success");
// wc_add_notice("teeeeeeeeeeeeest", "info");
// wc_add_notice("teeeeeeeeeeeeest", "warning");
// wc_add_notice("teeeeeeeeeeeeest", "error");

$model = \pockets::crud( 'woo/cart' )::initCached()->read( [
    'notices',
] );


?>

<pockets-woo-cart
    :query='<?= json_encode( $model->get( 'query' ) ) ?>'
    cart-id='cart-notices'
    #default='cart'
>
    <pockets-state-watcher
        :source='cart.results.notices'
        :immediate='true'
        :callback="notices => {
            Object.entries(notices).forEach(([type, entries]) => {
                entries.forEach(entry => {
                    $pockets.toast(entry.notice, { type })
                })
            })
        }"
    >
    </pockets-state-watcher>
     
</pockets-woo-cart>