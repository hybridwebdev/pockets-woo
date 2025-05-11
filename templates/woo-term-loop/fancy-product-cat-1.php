<?php 
/**
* Template Name: Fancy Product Cat 1
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

<div 
    class="term-loop-item d-flex"
    style="background-image: url('<?= $image_url ?>'); background-size: cover; background-position: center; aspect-ratio: 16 / 9; overflow: hidden;"
>
    <div class='bg-black col-12 bg-opacity-50 d-flex align-items-center p-2'>
        <a href="<?= $data['link']  ?>" class="fs-20 fw-8 text-center text-decoration-none p-2 text-white col-12 p-1 bg-black bg-opacity-25 fw-8">
            <?= $data['name'] ?>
        </a>
    </div>
</div>
