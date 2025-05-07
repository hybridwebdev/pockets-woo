<?php

/**
    Template Name: Woo Product Price 
    Template Type: woo-product-template
    Template Controller: controller
*/

$productData = $this->read_resource( [
    'product_type',
    "price_range:price"
] );

 
$renderPrice = fn() => sprintf(
    <<<T
    %s
    T,
    ( $productData['price']['max'] ?? false) 
        ? sprintf( "%s to %s", $productData['price']['min'], $productData['price']['max'] ) 
        : sprintf( "%s", $productData['price']['min'] ) 
);

if( $productData['product_type'] == "simple" ) {
    $price = $this->read_resource(['price'])['price'];
    printf(
        <<<'HTML'
            %s
        HTML,
        $renderPrice()
    );
}

if( $productData['product_type'] == "variable" ) {

    printf(
        <<<'HTML'
            <div 
                v-if='$pockets.woo.variation_form.selected' 
                v-html='$pockets.woo.variation_form.selected.price_html'
            >
            </div>
            <div v-else>
                %s
            </div>
        HTML,
        $renderPrice()
    );
    
}