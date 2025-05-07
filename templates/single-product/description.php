<?php

$productData = $this->read_resource( [
    'description',
    'product_type'
] );

if( $productData['product_type'] == "simple" ) {
    echo $productData['description'];
    return;
}

if( $productData['product_type'] == "variable" ) {

    printf(
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