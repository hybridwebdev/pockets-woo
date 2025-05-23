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
        : sprintf( "%s", $data['price']['min'] ?? "" ) 
);

$addItem = json_encode( $data['addItem'] );

?>
<div class='grid-card-4 bg-white gap-1 product p-2'>

    <div class='d-flex align-items-center justify-content-center'>
        <a href="<?= $data['link'] ?>">
            <img class='img-fluid img-thumbnail' src='<?= $data['image']['url']?>'>
        </a>
    </div>

    <a 
        href="<?= $data['link'] ?>" 
        class="text-black text-decoration-none fs-24 fw-6"
    >
        <?= $data['title'] ?>
    </a>

    <pockets-local-state 
        :item='<?= $addItem ?>'
        :busy='false'
        #default='{ state }'
    >
        <div :loading='state.busy' class='loading-container '>
            
            <span class='price d-block col-12 mb-2 fs-14'>
                <?= $renderPrice() ?>
            </span>
            
            <?php 
                if( in_array( needle: $data['product_type'], haystack: [ 'variable', 'grouped', 'external' ] ) ) {
            ?>
                <div>
                    <a 
                        href="<?php echo esc_url($data['link']); ?>" 
                        class='fs-14 btn btn-grey-800 text-white d-block text-center text-uppercase p-1 rounded-0 d-flex gap-1 align-items-center justify-content-center'
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
                            $pockets.woo.cart.addItem( { addItem: state.item } )
                            .then( e => {
                                if( e.addItem !== false ) {
                                    $pockets.toast.success("Item added to cart");
                                }
                                if( e.addItem === false ) {
                                    $pockets.toast.error("Item could not be added");
                                }
                            } )
                            .catch( e => e.toast() )
                            .finally( () => {
                                state.busy = false
                                state.item.quantity = 1;
                            })
                        '
                    >
                        <i class='fa fa-shopping-cart'></i>
                        Add
                    </button>
                </div>

            <?php } ?>
        
        </div>  

    </pockets-local-state>

</div>