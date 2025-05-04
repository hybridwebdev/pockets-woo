<?php

$productData = $this->read_resource( [
    'product_type'
] );

if( $productData['product_type'] == "simple" ) {
    $price = $this->read_resource(['price'])['price'];
    printf(
        <<<'HTML'
            %s
        HTML,
        $price
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
        "Price range here"
    );
    
}