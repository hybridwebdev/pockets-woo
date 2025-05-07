<?php

/**
    Template Name: Woo Product Add To Cart 
    Template Type: woo-product-template
*/

global $product;
$product = $this->resource;

woocommerce_template_single_add_to_cart(); 