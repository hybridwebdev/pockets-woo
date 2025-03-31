<?php 
/**
* Template Name: Generic Product Item 1
* Template Type: post
*/

$randomString = function (): string {
    $length = rand(10, 40); // Random length between 1 and 20
    return substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', ceil($length / 26))), 0, $length);
};

$data = $this->read_resource( [
    "ID",
    'title',
    'addItem',
    'image' => [
        'url' => [
            'fallback' => "https://placehold.co/400x300/efefef/000"
        ]
    ],
    'sku',
    'link',
    'price_range:price',
    'product_type' 
] );

$renderPrice = fn() => sprintf(
    <<<T
    <span class='text-black fs-14 fw-5 lh-22'>%s</span>
    T,
    ( $data['price']['max'] ?? false) 
        ? sprintf( "%s to %s", $data['price']['min'], $data['price']['max'] ) 
        : sprintf( "%s", $data['price']['min'] ) 
);


?>
<div class='grid-card-4 bg-white p-4 gap-1 product'>

    <div class='text-uppercase fs-14 lh-22 fw-5'>
        SKU: <?= $data['sku'] ?>
    </div>

    <div class='d-flex align-items-center justify-content-center'>
        <a href="<?= $data['link'] ?>">
            <img src='<?= $data['image']['url']?>'>
        </a>
    </div>

    <p class="product-title">   
        <a href="<?= $data['link'] ?>">
            <?= $data['title'] ?>
        </a>
    </p>

    <pockets-local-state 
        :item='<?= json_encode( [
            'product_id' => $data['ID'],
            'variation_id' => 0,
            'quantity' => 1
        ] ) ?>'
        :busy='false'
        #default='{ state }'
    >
        <div :loading='state.busy' class='loading-container'>
            
            <span class='price d-block col-12 mb-2 fs-14'>
                <?= $renderPrice() ?>
            </span>
            
            <?php 
                if( $data['product_type'] == 'variable' ) {
            ?>
                <div>
                    <a href="<?php echo esc_url($data['link']); ?>" class='fs-14 btn btn-outline-primary d-block text-center text-uppercase view-options'>View options</a>
                </div>
            <?php
                }
            ?>

            <?php if( $data['product_type'] =='simple') { ?>
                                    
                <div 
                    class='d-flex gap-1' 
                >
                    <pockets-fancy-input
                        :debounce='0'
                        v-model:value='state.item.quantity'
                    >
                    </pockets-fancy-input>    
                    
                    <button
                        type="button"
                        class='btn btn-primary text-uppercase fs-14 add-to-cart'
                        @click='
                            state.busy = true;
                            $pockets.woo.cart.addItem( { addItem: state.item } ).then( e => {
                                state.item.quantity = 1;
                                state.busy = false;
                                $pockets.toast.success("Item Added");
                            } )
                        '
                    >
                        Add to cart
                    </button>
                </div>

            <?php } ?>
        
        </div>  

    </pockets-local-state>

</div>