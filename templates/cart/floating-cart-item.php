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
         
    ],
    'subtotal',

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
<div class='d-flex gap-1 align-items-start pe-2 bg-white'>

    <div class='width: 100px'>
        <a href='<?= $data['link'] ?>' class='p-half d-block'>
            <img src='<?= $data['image']['url'] ?>' class='img-fluid' style='max-width: 100px'>
        </a>
    </div>

    <div class='floating-cart-item-contents'>
    
        <div class='d-flex align-items-center'>
            <a class='text-decoration-none' href='<?= $data['link'] ?>'>
                <span class='text-grey-800 fw-8 fs-18'><?= $data['title'] ?></span>
            </a>
            <i 
                class='text-danger fa fa-trash-alt product-remove ms-auto p-2 pe-0' role='button'
                @click='$pockets.woo.cart.removeItem( "<?= $data['key'] ?>" ).then( e => $pockets.toast.success("Item removed") )'
            ></i>
        </div>

        <div>
            <p class="product-sku"><?php echo $data['sku'] ?></p>
        </div>

        <div class='grid-info'>
            <span>Qty:</span>
            <pockets-fancy-input
                class='fs-10'
                :min='1'
                value='<?= $data['quantity']?>' 
                @update:value='quantity => $pockets.woo.cart.updateQuantity( "<?= $data['key'] ?>", quantity ).then( e => $pockets.toast.success("Quantity updated") )'
            >
            </pockets-fancy-input>
        </div>

        <p class="product-price">
            
        </p>
        
    </div>

</div>
