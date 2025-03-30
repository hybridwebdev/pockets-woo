<?php
echo "Hello world";
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
        // 'image' => [
        //     'url' => [
        //         'size' => 'medium',
        //         'fallback' => $fallback
        //     ]
        // ],
    ],
    'subtotal',
    'resource' // remove this
] );

\pockets::dump( $data ); 

return;

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
<rinnai-app class='d-flex gap-2 align-items-start border-bottom border-1 border-grey-400 pb-4'>

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
                @click='rinnai.cart.removeItem( "<?= $data['key'] ?>" ).then( e => rinnai.toast.success("Item removed") )'
            ></i>
        </div>

        <div>
            <p class="product-sku">[<?php echo $data['sku'] ?>]</p>
        </div>

        <div class='grid-info'>
            <span>Qty:</span>
            <fancy-input
                value='<?= $data['quantity']?>' 
                @update:value='quantity => rinnai.cart.updateQuantity( "<?= $data['key'] ?>", quantity ).then( e => rinnai.toast.success("Quantity updated") )'
            >
            </fancy-input>
        </div>

        <div class='grid-info'>
            <span>Output:</span>
            <span>14kW</span>
        </div>

        <p class="product-price">
            {{ rinnai.formatCurrency( <?= $data['subtotal'] ?> ) }}
        </p>
    </div>

</rinnai-app>
