<?php 
/**
* Template Name: Generic Product Cat 1
* Template Type: term
*/

$data = $this->read_resource([
    'name',
    'link',
    "ID"
]); 

$thumbnail_id = get_term_meta( $data['ID'], 'thumbnail_id', true );

$image_url = wc_placeholder_img_src( 'thumbnail' );

if ( $thumbnail_id ) {
    $image_url = wp_get_attachment_url( $thumbnail_id );
}

?>
<div class='term-loop-item'>
    <div class='grid-info-100'>
        <img src='<?= $image_url?>'>
        <a href='<?= $data['link']?>'>
            <?= $data['name'] ?>
        </a>
    </div>
</div>