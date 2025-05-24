<?php 
/**
* Template Name: Category Accordion
* Template Type: woo-shop-template
*/

$data = \pockets\utils\array_dot_prop::init( $data );

echo \pockets\templates\utils\category_accordion::init(
    currentTermIds: [ get_queried_object_id() ],
    parentQuery: $data->get( "parentQuery", [
        'taxonomy' => 'product_cat',
        'parent' => 0,
        'hide_empty' => false
    ] ),
    taxonomy: $data->get( "taxonomy", "product_cat" )
)->render(); 