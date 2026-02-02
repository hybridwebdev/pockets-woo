<?php
namespace pockets_woo\crud\models\woo\product;

trait terms {

    function terms( ?array $args ) : array | \WP_Error {
        
        if( !is_array($args) ) return \pockets::error("You must provide an array for an argument"); 

        list(
            'taxonomy' => $this->_create['taxonomy'],
            'append' => $this->_create['append'],
            'terms' => $this->_create['terms'],
            'using' => $this->_create['using'],
        ) = wp_parse_args( $args, [
            'taxonomy' => false,
            'append' => false,
            'terms' => false,
            'using' => "ID"
        ] );
        
        if( !is_string($this->_create['taxonomy']) ) {
            return \pockets::error( "You must provide a taxonomy argument as a string,");
        }

        if( !taxonomy_exists( $this->_create['taxonomy'] ) ) {
            return \pockets::error( "You must provide a valid taxonomy name,");
        }
        
        if( !is_array( $this->_create['terms'] ) ) {
            return \pockets::error("You must provide an array of terms");
        }

        if( !is_string( $this->_create['using'] ) ) {
            return \pockets::error("You must provide a using argument as a string");
        }

        if( $this->_create['using'] == 'ID') {

            $IDS = array_filter( 
                array: $this->_create['terms'], 
                callback: fn($term) => is_numeric( $term ) 
            );

            if( count($IDS) != count( $this->_create['terms'] ) ) {
                return \pockets::error("You must provide a list of terms that only contains IDS.");
            }

            $updated = wp_set_post_terms( $this->resource->get_id(), $IDS, $this->_create['taxonomy'], $this->_create['append'] );
            
            if( is_wp_error( $updated ) ) {
                return $updated;
            }

        }

        return [ 'updated' => true ];

    }

}

trait variations {
    
    function attributes( array $values ){
        $this->resource->set_attributes( $values );
    }

    function attribute_list( array $attributes ) {

        $attrs = array_map(
            array: $attributes,
            callback: function( array $attribute ){

                list(
                    'name' => $name,
                    'options' => $options,
                    'visibile' => $visible,
                    'variation' => $variation,
                    'position' => $position,
                    'id' => $id
                ) = wp_parse_args( $attribute, [
                    'name' => false,
                    'options' => false,
                    'visibile' => 1,
                    'variation' => 1,
                    'position' => 0,
                    'id' => 0
                ] );

                $attr = new \WC_Product_Attribute();

                if( !$name ) {
                    return \pockets::error("Name is required");
                }

                if( !$options ) {
                    return \pockets::error( "Attribute requires options as either a string or an array" );
                }

                $attr->set_name( $name );
                $attr->set_options( $options );
                $attr->set_visible( $visible );
                $attr->set_variation( $variation );
                $attr->set_position( $position );
                $attr->set_id( $id );

                return $attr;

            }

        );
        
        $errors = array_filter(
            array: $attrs,
            callback: fn( $attr ) => is_wp_error( $attr )
        );

        if( count( $errors ) > 0 ) {
            return \pockets::error( "Attributes could not be set as they contain errors", $errors );
        }

        $this->resource->set_attributes( $attrs );
        
        return true;

    }

    /**
        Updates product variations and attributes.
        
        This function accepts an array of arguments to update a variable product's 
        attributes and variations. If an attribute list is provided, it sets the 
        attributes for the product. If variation items are provided, it iterates 
        through them, finding or creating variations, updating their properties, 
        and saving them under the parent product.
        
        After processing, it synchronizes variations using WooCommerce's built-in 
        `sync` method to ensure consistency.
        
        * @param array $args {
            Optional. An array of arguments.
    
            @type array $attribute_list List of attributes to set for the product.
            @type array $items List of variations to update or create.
        * }
    */
    function variations( array $args ) {
        
        list(
            'attribute_list' => $attribute_list,
            'items' => $items,
        ) = wp_parse_args( $args, [
            'attributes' => false,
            'items' => false
        ] );

        if( $attribute_list ) {
            $this->attribute_list( $attribute_list );
        }
        
        if( $items ) {
            
            /**
                - Iterate list of items.
                - Try and find an existing variation based
                    on parentID and the variations attributes.
                    Will make a new variation if none found. 
                - Update variation.
            */
            array_map(
                array: $items,
                callback: function( $item ){

                    $variation = \pockets::crud('woo/product/variation')::init( [
                        'by' => "attributes",
                        'parentID' => $this->resource->get_id(),
                        'attributes' => $item['attributes'] 
                    ] )->resource;

                    if( is_wp_error( $variation ) ) {
                        return $variation;
                    }

                    /**
                        $variation might be a new instance. Save so that it gets an ID.  
                    */
                    $variation->save();
                    
                    /**
                        Add parent_id to update data so that variation gets parent set.
                    */
                    $item['parent_ID'] = $this->resource->get_id();

                    \pockets::crud("woo/product/variation")::init( $variation->get_id() )->update( $item, false );

                }
            );

        }

        \WC_Product_Variable::sync( $this->resource->get_id() );

        return "Updated";

    }

}

class update extends \pockets\crud\resource_walker {
    
    use terms;
    use variations;

    function parent_ID( $ID ){
        $this->resource->set_parent_id( $ID );
        return "Updated";
    }

    function title( string $title ){
        
        $this->resource->set_name( wp_kses_post( $title ) );
        
        return "Updated";

    }
 
    function regular_price( float $price ){
        $this->resource->set_regular_price( $price );
    }

    function image( int $ID ) : array | \Wp_Error {
        
        if( $ID === 0 ){
            delete_post_meta( $this->resource->get_id(), '_thumbnail_id' );
            return [ 'updated' => true, 'message' => "Unset Featured Image"];
        }

        if( get_post($ID) && wp_get_attachment_image( $ID, 'thumbnail' ) ) {
            update_post_meta( $this->resource->get_id(), '_thumbnail_id', $ID );
            return [ 'updated' => true, 'message' => "Updated Featured Image"];
        }

        return \pockets::error("Image does not exist");

    }

    function upload_featured_image( string $url ){
        
        $image = \pockets::crud('image')::init()->create( [
            'url' => $url
        ], ['ID'] );

        if( is_wp_error( $image) ) {
            return $image;   
        }
        
        return $this->image( $image['ID'] );

    }

    function content( string $content ) : string | \Wp_Error {

        $res = wp_update_post( [
            'ID'           => $this->resource->get_id(),
            'post_content' => wp_kses_post( $content ), 
        ] );

        if( is_wp_error( $res ) ) {
            return $res;
        }

        return "Updated";

    }

    function stock( int $stock ) {
        $this->resource->set_stock_quantity( $stock );
    }

    function sku( string $sku ){
        
        $this->resource->set_sku( $sku );

    }

    function manage_stock( bool $manage ) {

        $this->resource->set_manage_stock( $manage );

    }
    
    /**
        Updates post meta
        Uses a whitelisting approach for security. 
        New keys can be added via register_meta();
        @class-document-link https://developer.wordpress.org/reference/functions/register_meta/ 
    */
    #[ \pockets\crud\schema\attribute( __CLASS__.'::__get_meta_schema' ) ]
    function meta( array $args ) : array | \WP_Error {
        if( !is_array( $args ) ) return \pockets::error("Denied");
        return \pockets\crud\reducers\whitelist_reducer::walk(
            array: $args, 
            callback: fn( $value, $iterator ) => update_post_meta( $this->resource->get_id(), $iterator->key, $iterator->value ) ? "Updated" : "Updated",
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
            action: "update",
            meta_object_type: "post",
        );
    }

}