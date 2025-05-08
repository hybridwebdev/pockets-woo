<?php

$fallback = "https://placehold.co/100x100/efefef/000";

$data = $this->read_resource( [
    'key',
    'quantity',
    'product:<=' => [
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
<div class='cart-item-columns bg-white'>

    <div class='image-column p-half'>
        <a href='<?= $data['link'] ?>' class='image-column'>
            <img src='<?= $data['image']['url'] ?>' class='img-fluid'>
        </a>
    </div>

    <div class='d-flex align-items-center product-column'>



        <a class='text-decoration-none' href='<?= $data['link'] ?>'>
            <span class='text-grey-800 fw-8 fs-18'><?= $data['title'] ?></span>
        </a>
        
        <i 
            class='btn btn-outline-danger fa fa-trash-alt product-remove p-1 ms-auto border-0'
            v-tooltip='"Remove item from cart"'
            @click='$pockets.woo.cart.removeItem( "<?= $data['key'] ?>" ).then( e => $pockets.toast.success("Item removed") )'
        ></i>

    </div>
    
    <div class='price-column'>
        <?= $data['price'] ?>
    </div>

    <div class='quantity-column'>
        <pockets-fancy-input
            class='fs-10'
            :min='1'
            value='<?= $data['quantity']?>' 
            @update:value='quantity => $pockets.woo.cart.updateQuantity( "<?= $data['key'] ?>", quantity ).then( e => $pockets.toast.success("Quantity updated") )'
        >
        </pockets-fancy-input>
    </div>

    <div class='subtotal-row'>
        <?= $data['subtotal'] ?>
    </div>

</div>
