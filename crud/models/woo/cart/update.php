<?php
namespace pockets_woo\crud\models\woo\cart;

class update extends \pockets\crud\resource_walker {

    /**
        Adds item to cart.
    */
    function addItem( $data ) : string | bool {
        
        list(
            'quantity' => $quantity,
            'product_id' => $product_id,
            'variation_id' => $variation_id,
            'variation' => $variation,
            'cart_item_data' => $cart_item_data 
        ) = $data;

        wp_parse_args( [
            'quantity' => 1,
            'product_id' => 0,
            'variation_id' => 0,
            'variation' => [],
            'cart_item_data' => []
        ], $data );

        return $this->resource->add_to_cart( 
            $product_id, 
            $quantity, 
            $variation_id, 
            $variation, 
            $cart_item_data 
        );

    }

    function removeItem( string $hash ){
        return $this->resource->remove_cart_item( $hash );
    }

    function itemQuantity( array $data ){

        list(
            'hash' => $hash,
            'quantity' => $quantity
        ) = $data;

        if( $quantity <= 0 ) {
            $quantity = 1;
        }
        
        return $this->resource->set_quantity( $hash, (int) $quantity );

    }

}