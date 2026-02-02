<?php
namespace pockets_woo\crud\models\woo\product;
 

class read extends \pockets\crud\resource_walker {
    
    use \pockets\crud\render;

    function image( array $read ) : \Wp_Error | array {
        //"https://place-hold.it/80x80"
        $image_id = get_post_thumbnail_id( $this->resource->get_id() ) ?? false;
        return \pockets::crud( 'image' )::init( $image_id )->read( $read );

    }
 
    function ID(){
        return $this->resource->get_id();
    }

    function title(){
        return $this->resource->get_name();
    }

    function sku(){
        return $this->resource->get_sku();
    }

    function price( ?array $args ){
        return \pockets\woo::wc_price( $this->resource->get_price(), $args );
    }

    function parentID(){
        return $this->resource->get_parent_id();
    }

    function isVariation(){
        return $this->resource->is_type('variation');
    }

    /**
        Returns an object that can be used to add this product to the cart
        using wc()->cart->add_to_cart(). 
    */
    function addItem(){

        $isVariation = $this->isVariation();

        return [
            'quantity' => 1,
            'product_id' =>  $isVariation ? $this->parentID() : $this->ID(),
            'variation_id' => $isVariation ? $this->ID() : 0,
            'variation' => [],
            'cart_item_data' => []
        ];

    }

    function link( ?array $args = [ 'relative' => true ] ) : string {
        $link = get_the_permalink( $this->resource->get_id() );
        if( $args['relative'] ?? false === true) {
            return wp_make_link_relative( $link );
        }
        return $link;
    }

    function price_range( ?array $args = [] ){
         
        if ( $this->resource->is_type( 'variable' ) ) {

            return [
                'min' => \pockets\woo::wc_price( $this->resource->get_variation_price( 'min' ), $args ),
                'max' => \pockets\woo::wc_price( $this->resource->get_variation_price( 'max' ), $args )
            ];

        } 
        
        if ( in_array( needle: $this->resource->get_type(), haystack: [ 'simple', 'external'] ) ) {

            return [
                'min' => \pockets\woo::wc_price( $this->resource->get_price(), $args )
            ];

        }

        if ( $this->resource->is_type( 'grouped' ) ) {
            //
            $prices = array_map(
                array: $this->resource->get_children(),
                callback: fn( int $ID ) => wc_get_product( $ID )->get_price()
            );
            // Calculate the min and max prices
            $min_price = min( $prices );
            $max_price = max( $prices );
            
            return [
                'min' => \pockets\woo::wc_price( $min_price, $args ),
                'max' => \pockets\woo::wc_price( $max_price, $args )
            ];

        }

    }

    function product_type(){
        return $this->resource->get_type();
    }

    /**
        This is wrong. 
    */
    function parentProduct( array $read ) : \WP_Error | array {
        
        if ( !$this->resource->is_type( 'variable' ) ) {
            return \pockets::error("This is not a variable product");
        }
        
        return \pockets::crud('woo/product')::init( $this->resource->get_id() )->read( $read );

    }

    function description(){
        return apply_filters( 'woocommerce_description', $this->resource->get_description() );
    }

    function short_description(){
        return apply_filters( 'woocommerce_short_description', $this->resource->get_short_description() );
    }
    
    function variationParent( $read ) {
        return \pockets::crud('woo/product')::init( $this->resource->get_parent_id() )->read( $read );
    }

    
    /**
        You can provide an array of meta_keys, and this will return an array of results for the 
        corresponding field.
    */
    #[ \pockets\crud\schema\attribute( __CLASS__.'::__get_meta_schema' ) ]
    function meta( ?array $args ) : array | \WP_Error {
        if( !is_array( $args ) ) return \pockets::error("Denied");
        return \pockets\crud\reducers\whitelist_reducer::walk(
            array: $args, 
            callback: fn($_, $iterator) => get_post_meta($this->resource->ID, $iterator->key, true),
            whitelist: array_keys( get_registered_meta_keys('post') )
        );
    }

    /**
        @class-document-advanced
        This is used to dynamically generate schema for the meta function.
    */    
    static function __get_meta_schema(){
        return \pockets\crud\schema\registered_meta_keys::build( 
            meta_keys: get_registered_meta_keys('post'),
            action: "read",
            meta_object_type: "post",
        );
    }

}