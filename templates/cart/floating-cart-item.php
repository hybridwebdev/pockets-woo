<?php

$fallback = "https://placehold.co/100x100/efefef/000";

$data = $this->read_resource( [
    'key',
    'quantity',
    'product:<=' => [
        'link',
    ],
    'item_info:<=' => [
        'title',
        'product_type',
        'sku',
         
    ],
    'subtotal',

] );

$data['image'] = \pockets::error("");

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
<div class='d-flex gap-2 align-items-start border-bottom border-1 border-grey-400 pb-4'>

    <div class='width: 100px'>
        <a href='<?= $data['link'] ?>'>
            <img src='<?= $data['image']['url'] ?>' class='img-fluid' style='max-width: 100px'>
        </a>
    </div>

    <div class='floating-cart-item-contents'>
        <div class='d-flex align-items-center'>
            <a href='<?= $data['link'] ?>' class="product-title">
                <span class='text-black'><?= $data['title'] ?></span>
            </a>
            <i 
                class='fa fa-trash-alt product-remove ms-auto p-2 pe-0' role='button'
                @click='$pockets.woo.cart.removeItem( "<?= $data['key'] ?>" ).then( e => $pockets.toast.success("Item removed") )'
            ></i>
        </div>

        <div>
            <p class="product-sku">[<?php echo $data['sku'] ?>]</p>
        </div>

        <div class='grid-info'>
            <span>Qty:</span>
            <input
                type='number'
                value='<?= $data['quantity']?>' 
                @input='e => $pockets.woo.cart.updateQuantity( "<?= $data['key'] ?>", e.target.value ).then( e => $pockets.toast.success("Quantity updated") )'
            >
            </input>
        </div>

        <p class="product-price">
            
        </p>
        
    </div>

</div>
