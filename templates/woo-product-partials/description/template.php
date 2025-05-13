<?php

/**
    Template Name: Woo Product Description 
    Template Type: woo-product-template
    Template Controller: controller
*/

$productData = $this->read_resource( [
    'description',
    'product_type'
] );

if( in_array( needle: $productData['product_type'], haystack: ['simple', 'external', 'grouped'] ) ) {
    return printf( $productData['description'] );
}

if( $productData['product_type'] == "variable" ) {

    return printf(
        <<<'HTML'
            <div 
                v-if='$pockets.woo.variation_form.selected' 
                v-html='$pockets.woo.variation_form.selected.variation_description'
            >
            </div>
            <div v-else>
                %s
            </div>
        HTML,
        $productData['description']
    );
    
}