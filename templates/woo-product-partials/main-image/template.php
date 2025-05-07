<?php

/**
    Template Name: Woo Product Main Image 
    Template Type: woo-product-template
    Template Controller: controller
*/

$productData = $this->read_resource( [
    'product_type',
    'image' => [
        'url' => [
            'fallback' => woocommerce_placeholder_img_src()
        ]
    ]
] );

if( $productData['product_type'] == "simple" ) {

    return printf(
        <<<'HTML'
            <img src='%s'>
        HTML,
        $productData['image']['url']
    );
    
}

if( $productData['product_type'] == "variable" ) {

    printf(
        <<<'HTML'
            <img 
                v-if='$pockets.woo.variation_form.selected && $pockets.woo.variation_form.selected.image.src!=""' 
                :src='$pockets.woo.variation_form.selected.image.src'
            >
            <img v-else src='%1$s' />
        HTML,
        $productData['image']['url']
    );
    
}