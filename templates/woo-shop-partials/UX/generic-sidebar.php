<?php 
/**
* Template Name: UX - Generic Sidebar
* Template Type: woo-shop-template
*/

echo \pockets_woo\templates\woo_shop_partials\UX\category_sidebar::init(
    currentTermIds: [ get_queried_object_id() ],
    parentQuery: [
        'taxonomy' => 'product_cat',
        'parent' => 0,
        'hide_empty' => false
    ]
)->render(); 