<?php

/**
    Template Name: Woo Product Main Image 
    Template Type: woo-product-template
    Template Controller: controller
*/

$imageOptions = wp_parse_args(
    $data,
    [
        'class' => "",
        'size' => "full"
    ],
);

$productData = $this->read_resource( [
    'product_type',
    'image' => [
        'url' => [
            'fallback' => woocommerce_placeholder_img_src(),
            'size' => $imageOptions['size']
        ]
    ]
] );


if( $productData['product_type'] == "simple" ) {

    return printf(
        <<<'HTML'
            <img src='%1$s' class='%2$s'>
        HTML,
        $productData['image']['url'],
        $imageOptions['class']
    );
    
}

if( $productData['product_type'] == "variable" ) {

    printf(
        <<<'HTML'
            <img 
                v-if='$pockets.woo.variation_form.selected && $pockets.woo.variation_form.selected.image.src!=""' 
                :src='$pockets.woo.variation_form.selected.image.src'
                class='%2$s'
            >
            <img 
                v-else 
                src='%1$s' 
                class='%2$s'
            />
        HTML,
        $productData['image']['url'],
        $imageOptions['class']
    );
    
}