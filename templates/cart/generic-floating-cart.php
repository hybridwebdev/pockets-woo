<?php
    $data = $this->read_resource([
        'total',
        'items' => [
            'render' => [
                'template' => 'cart/floating-cart-item'
            ]
        ]
    ]);
?>
<div>
    I am the floating cart.
    <button @click='$pockets.woo.cart.hash++'>
        Update
    </button>
    $<?= $data['total'] ?>
    <?php
        array_map( 
            array: $data['items'],
            callback: fn( $item ) => printf( $item['render'])
        );
    ?>
</div>