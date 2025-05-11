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
<div class='d-flex gap-1 align-items-start pe-2 pb-2 bg-white'>

    <div class='width: 100px'>
        <a href='<?= $data['link'] ?>' class='p-1 d-block'>
            <img src='<?= $data['image']['url'] ?>' class='img-fluid' style='max-width: 100px'>
        </a>
    </div>

    <div class='cart-item-compact-contents pt-1'>
    
        <div class='d-flex align-items-center'>
            <a class='text-decoration-none' href='<?= $data['link'] ?>'>
                <span class='text-grey-800 fw-8 fs-18'><?= $data['title'] ?></span>
            </a>
            <button 
                class='product-remove ms-auto p-1 btn btn-outline-danger border-0'
                @click='$pockets.woo.cart.removeItem( "<?= $data['key'] ?>" ).then( e => $pockets.toast.success("Item removed") )'
            >
                <i class='fa fa-trash-alt'></i>
            </button>
        </div>


       <div class='grid columns-1 gap-1'>
            
            <?php if($data['sku']!='') {?>
                <div>
                    <p class="product-sku"><?php echo $data['sku'] ?></p>
                </div>
            <?php } ?>
            
            <div class="grid-info">
                <span>Price</span>
                <span><?= $data['price']?></span>
            </div>
            <div class="grid-info">
                <span>Subtotal</span>
                <span><?= $data['subtotal']?></span>
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

       </div>

        
    </div>

</div>
