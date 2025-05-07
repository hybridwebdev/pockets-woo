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
        'size' => "full",
        'fallback' => '',
        'style' => ""
    ],
);

if( $imageOptions['fallback'] == '' ) {
    $imageOptions['fallback'] = wc_placeholder_img_src( $imageOptions['size'] );
}

$productData = $this->read_resource( [
    'product_type',
    'image' => [
        'url' => [
            'fallback' => $imageOptions['fallback'],
            'size' => $imageOptions['size']
        ]
    ]
] );


if( $productData['product_type'] == "simple" ) {

    return printf(
        <<<'HTML'
            <img src='%1$s' class='%2$s' style='%3$s'>
        HTML,
        $productData['image']['url'],
        $imageOptions['class'],
        $imageOptions['style']
    );
    
}

if( $productData['product_type'] == "variable" ) {

    printf(
        <<<'HTML'
            <img 
                v-if='$pockets.woo.variation_form.selected && $pockets.woo.variation_form.selected.image.src!=""' 
                :src='$pockets.woo.variation_form.selected.image.src'
                class='%2$s'
                style='%3$s'
            >
            <img 
                v-else 
                src='%1$s' 
                class='%2$s'
                style='%3$s'
            />
        HTML,
        $productData['image']['url'],
        $imageOptions['class'],
        $imageOptions['style']
    );
    
}