<?php

$fallback = "https://placehold.co/100x100/efefef/000";
 
$data = $this->read_resource( [
    'key',
    'quantity',
    'product:<=' => [
        'ID',
        'link',
        'image' => [
            'url' => [
                'fallback' => $fallback
            ]
        ],
    ],
    'item_info:<=' => [
        'title',
        'product_type',
        'sku',
        'price' 
    ],
    'subtotal'

] );

$data['price'] = apply_filters( "woocommerce_get_price_html", $data['price'], wc_get_product($data['ID']));

if( $data['product_type'] == 'variation') {
    
    $variation = $this->read_resource( [
        'variation:<=' => [
            'variationParent:<=' => [
                "title",
            ]
        ]
    ] );

    $data = array_merge( $data, $variation );
}

if( is_wp_error( $data['image'] ) ) {
    $data['image'] = [
        'url' => $fallback
    ];
}

?>
<div class='cart-item-column-layout bg-white'>

    <div class='product-column product-column-image' label=' '>
        <a href='<?= $data['link'] ?>' class='p-lg-half p-xs-0 d-block'>
            <img src='<?= $data['image']['url'] ?>' class='img-fluid'>
        </a>
    </div>

    <div class='product-column' label='Product'>

        <div class='d-flex align-items-center' >
    
            <a class='text-decoration-none' href='<?= $data['link'] ?>'>
                <span class='text-grey-800 fw-8 fs-18'><?= $data['title'] ?></span>
            </a>
            
            <i 
                class='btn btn-outline-danger fa fa-trash-alt product-remove p-1 ms-auto border-0'
                v-tooltip='"Remove item from cart"'
                @click='e => {
                    $pockets.woo.cart.removeItem( "<?= $data['key'] ?>" )
                    .then( e => $pockets.toast.success("Item removed") )
                    .catch( e => e.toast() )
                }'
            ></i>
    
        </div>

    </div>
    
    <div class='product-column' label='Price'>
        <?= $data['price'] ?>
    </div>

    <div class='product-column' label='Quantity'>
        <pockets-fancy-input
            class='fs-10'
            :min='1'
            value='<?= $data['quantity']?>' 
            @update:value='quantity => {
                $pockets.woo.cart.updateQuantity( "<?= $data['key'] ?>", quantity )
                .then( e => $pockets.toast.success("Quantity updated") )
                .catch( err => err.toast() )
            }'
        >
        </pockets-fancy-input>
    </div>

    <div class='product-column' label='Subtotal'>
        <?= $data['subtotal'] ?>
    </div>

</div>
