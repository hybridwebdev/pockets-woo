<?php
namespace pockets_woo\crud\models\woo\product_variation;
 
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

    /**
        Finds a product variation that matches the given attributes.
        
        This function queries WooCommerce product variations belonging to a specific parent product 
        and filters them based on the provided attribute values. If a matching variation is found, 
        it returns a `WC_Product_Variation` instance for that variation. If no match is found, 
        it returns an empty `WC_Product_Variation` object.
        
        * @param $parentID   The ID of the parent variable product.
        * @param $attributes An associative array of attributes to match (e.g., ['color' => 'red']).
    */
    function array_by_attributes( array $args ) : \WC_Product_Variation | \Wp_Error {

        list(
            'parentID' =>  $parentID, 
            'attributes' => $attributes,
            'queryArgs' => $queryArgs
        ) = wp_parse_args( $args, [
            'parentID' => false,
            'attributes' => false,
            'queryArgs' => []
        ] );

        if( !is_int($parentID) )  {
            return \pockets::error("parentID must be an integer.");
        }

        if( !is_array( $attributes ) ) {
            return \pockets::error("attributes must be an array of registered attributes.");
        }

        if( !is_array( $queryArgs ) ) {
            return \pockets::error("queryArgs must be an array of valid wp_query arguments.");
        }

        $meta_query = array_reduce(
            array: array_keys( $attributes ), 
            callback: fn( array $acc, string $attr_name ) : array => array_merge(
                $acc,
                [
                    [
                        'key'     => 'attribute_' . sanitize_title( $attr_name ),
                        'value'   => $attributes[ $attr_name ],
                        'compare' => '='
                    ]
                ]
            ), 
            initial: [
                'relation' => 'AND'
            ]
        );

        $query = new \WP_Query( [
        
            'post_parent' => $parentID,
            'meta_query' => $meta_query,
            'limit' => 1,
            'post_type' => 'product_variation',
            'post_status'  => 'any',
            
        ] + $queryArgs );

        if ( count( $query->posts ) == 0 ) {
            return new \WC_Product_Variation();
        }

        return new \WC_Product_Variation( $query->posts[0]->ID );

    }   

}
