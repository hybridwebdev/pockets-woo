<?php
namespace pockets_woo\crud\models\woo\product;
 
class get extends \pockets\crud\get_resource {
    
    function request_using_object(){
        return wc_get_product( $this->resource );
    }

    function request_using_string(){
        return wc_get_product( $this->resource );
    }

    function request_using_integer(){
        return wc_get_product( $this->resource );
    }
    
    function array_by_meta_key( array $args ){

        list(
            'meta_key' => $meta_key,
            'meta_value' => $meta_value
        ) = wp_parse_args($args, [
            'meta_key' => false,
            'meta_value' => false
        ] );

        if( !$meta_key || !$meta_value ) {
            return \pockets::error("Must provide a meta_key and meta_value argument");
        }

        $query = new \WP_Query( [
            'post_type' => "product",
            'posts_per_page' => 1, 
            'meta_query' => [
                'relation' => "AND",
                [
                    'key'   => $meta_key,
                    'value' => $meta_value,
                    'compare' => "="
                ]
            ]
        ] );

        if( count( $query->posts ) == 0 ) {
            return \pockets::error("No results found.");
        }

        return wc_get_product( $query->posts[0]->ID );

    }

    /**
        Class must pass a valid sub_class of wc_product.
    */
    function array_by_class(){
        
        return match( $this->resource['type'] ) {
            'simple' => '\WC_Product_Simple',
            'variable' => '\WC_Product_Variable',
            'variation' => '\WC_Product_Variation',
            default => \pockets::error('Invalid class type')
        };

    }
 
}
