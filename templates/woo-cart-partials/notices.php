<?php

/**
    Template Name: Woo Cart Notices
    Template Type: woo-cart-template
*/

// wc_add_notice("success", "success");
// wc_add_notice("info", "info");
// wc_add_notice("warning", "warning");
// wc_add_notice("error", "error");

$model = \pockets::crud( 'woo/cart' )::initCached()->read( [
    'notices',
] );

?>

<pockets-woo-cart
    :query='<?= json_encode( $model->get( 'query' ) ) ?>'
    cart-id='cart-notices'
    #default='cart'
>

    <pockets-watch-state
        :source='cart.results.notices'
        :immediate='true'
        :callback="notices => {
            Object.entries( notices ).forEach( ( [ type, entries ] ) => {
                entries.forEach( entry => {
                    $pockets.toast(entry.notice, { type })
                } )
            })
        }"
    >
    </pockets-watch-state>
     
</pockets-woo-cart>