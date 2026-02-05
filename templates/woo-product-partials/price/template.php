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

$renderPrice = fn() => apply_filters( "woocommerce_get_price_html", sprintf(
    <<<T
    %s
    T,
    ( $productData['price']['max'] ?? false ) 
        ? sprintf( "%s to %s", $productData['price']['min'], $productData['price']['max'] ) 
        : sprintf( "%s", $productData['price']['min'] ) 
), $this->resource );

if( in_array( needle: $productData['product_type'], haystack: [ 'simple', 'external', 'grouped' ] ) ) {
    
    return printf(
        <<<'HTML'
            %s
        HTML,
        $renderPrice()
    );

}
 
if( $productData['product_type'] == "variable" ) {

    return printf(
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