<?php 

/**
    Template Name: Generic Product Item 1
    Template Type: post
*/

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
<div class='grid-card-4 bg-white gap-1 product p-4'>

    <div class='d-flex align-items-center justify-content-center'>
        <a href="<?= $data['link'] ?>" class=''>
            <img src='<?= $data['image']['url']?>'>
        </a>
    </div>

    <a 
        href="<?= $data['link'] ?>" 
        class="text-black text-decoration-none fs-24 fw-6"
    >
        <?= $data['title'] ?>
    </a>

    <pockets-local-state 
        :item='<?= json_encode( [
            'product_id' => $data['ID'],
            'variation_id' => 0,
            'quantity' => 1
        ] ) ?>'
        :busy='false'
        #default='{ state }'
    >
        <div :loading='state.busy' class='loading-container '>
            
            <span class='price d-block col-12 mb-2 fs-14'>
                <?= $renderPrice() ?>
            </span>
            
            <?php 
                if( $data['product_type'] == 'variable' ) {
            ?>
                <div>
                    <a 
                        href="<?php echo esc_url($data['link']); ?>" 
                        class='fs-14 btn btn-grey-800 text-white d-block text-center text-uppercase view-options p-1 rounded-0 d-flex gap-1 align-items-center justify-content-center'
                    ><i class='fa fa-cog'></i>View options</a>
                </div>
            <?php
                }
            ?>

            <?php if( $data['product_type'] =='simple' ) { ?>
                                    
                <div 
                    class='d-flex gap-1' 
                >
                    <pockets-fancy-input
                        :debounce='0'
                        v-model:value='state.item.quantity'
                        style='max-width: 180px'
                    >
                    </pockets-fancy-input>    
                    
                    <button
                        type="button"
                        class='btn btn-outline-confirm text-uppercase fs-14 add-to-cart rounded-0 flex-grow-1 d-flex align-items-center gap-1 justify-content-center'
                        @click='
                            state.busy = true;
                            $pockets.woo.cart.addItem( { addItem: state.item } ).then( e => {
                                console.log(e );
                                state.item.quantity = 1;
                                state.busy = false;
                                if( e.addItem !== false ) {
                                    $pockets.toast.success("Item added to cart");
                                }
                                if( e.addItem === false ) {
                                    $pockets.toast.error("Item could not be added");
                                }
                            } )
                        '
                    >
                        <i class='fa fa-shopping-cart'></i>Add to cart
                    </button>
                </div>

            <?php } ?>
        
        </div>  

    </pockets-local-state>

</div>