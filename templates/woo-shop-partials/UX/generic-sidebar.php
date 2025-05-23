<?php 
/**
* Template Name: UX - Generic Sidebar
* Template Type: woo-shop-template
*/

echo \pockets\templates\category_accordion::init(
    currentTermIds: [ get_queried_object_id() ],
    parentQuery: [
        'taxonomy' => 'product_cat',
        'parent' => 0,
        'hide_empty' => false
    ],
    taxonomy: "product_cat"
)->render(); 