<?php
    \pockets::inject_data('aaaaaaa', ['a']);
    $data = $this->read_resource([
        'total'
    ]);
?>
<div>
    I am the floating cart.
    <button @click='$pockets.woo.cart.hash++'>
        Update
    </button>
    <?= $data['total'] ?>
</div>