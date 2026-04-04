<?php
namespace pockets_woo\crud\models\woo\cart;

class update extends \pockets\crud\resource_walker {

    /**
        Adds item to cart.
    */
    function addItem( $data ) : array {
        
        $data = wp_parse_args( $data, [
            'quantity' => 1,
            'product_id' => 0,
            'variation_id' => 0,
            'variation' => [],
            'cart_item_data' => []
        ] );

        list(
            'quantity' => $quantity,
            'product_id' => $product_id,
            'variation_id' => $variation_id,
            'variation' => $variation,
            'cart_item_data' => $cart_item_data 
        ) = $data;
            
        /**
            Allows filter the chance to prevent item from being added
        */

        $added = apply_filters( 
            'woocommerce_add_to_cart_validation', 
            true, 
            $product_id, 
            $quantity, 
            $variation_id, 
            $cart_item_data 
        );

        if( $added ) {

            $added = $this->resource->add_to_cart( 
                $product_id, 
                $quantity, 
                $variation_id, 
                $variation, 
                $cart_item_data 
            );

        }

        $message = "Item Added!";

        if( !$added ) {
            $message = $this->__get_error_messages();
        }
        
        return [
            'added' => $added,
            'message' => $message,
        ];

    }

    function removeItem( string $hash ) : array {

        if( $hash == '' ) {
            return [
                'removed' => false,
                'message' => "must provide a hash",
            ];
        }

        $cart_item = $this->resource->get_cart_item( $hash );

        if( !$cart_item ) {
            return [
                'removed' => false,
                'message' => "Could not find cart item.",
            ];
        }
    
        /**
            Allows filter the chance to prevent item from being removed 
        */

        $removed = apply_filters(
            'woocommerce_update_cart_validation',
            true,
            $hash,
            $cart_item,
            0
        );

        if( $removed ) {
            $removed = $this->resource->remove_cart_item( $hash );
        }

        $message = "Item removed!";

        if( !$removed ) {
            $message = $this->__get_error_messages();
        }

        return [
            'removed' => $removed,
            'message' => $message
        ];

    }

    function itemQuantity( array $data ) : array {
        
        $data = wp_parse_args( $data, [
            'hash' => null,
            'quantity' => 1,
        ] );

        list(
            'hash' => $hash,
            'quantity' => $quantity
        ) = $data;

        if( !$hash ) {
            return [
                'updated' => false,
                'message' => "No hash"
            ];
        }

        if( $quantity <= 0 ) {
            $quantity = 1;
        }

        $cart_item = $this->resource->get_cart_item($hash);

        if( !$cart_item ) {
            return [
                'updated' => false,
                'message' => "Could not find cart item.",
            ];
        }

        /**
            Allows filter the chance to prevent item quantity from being changed
        */

        $updated = apply_filters(
            'woocommerce_update_cart_validation',
            true,
            $hash,
            $cart_item,
            $quantity
        );

        if( $updated ) {
            $updated = $this->resource->set_quantity( $hash, (int) $quantity );
        }

        $message  = "Item quantity updated!";

        if( !$updated ) {
            $message = $this->__get_error_messages();
        }

        return [
            'updated' => $updated,
            'message' => $message
        ];

    }
    
    private function __get_error_messages() {
       
        $errors = wc_get_notices('error');

        $message = array_map( array: $errors, callback: fn( $error ) => $error['notice'] );

        $message = join( "", $message );

        wc_set_notices([
            'error' => []
        ] + wc_get_notices());

        return $message;
    
    }

}