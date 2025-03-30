<?php
namespace pockets_woo\crud\models\woo\product;

class model extends \pockets\crud\model {
    
    use permissions;
    
    static string $model_name = 'woo/product';
    public string $read_resource = __NAMESPACE__.'\read';
    public string $update_resource = __NAMESPACE__.'\update';
    public string $get_resource = __NAMESPACE__.'\get';
 
    function create( array $update, array | bool $read ) : bool | \WP_Error | array {
        
        if( !$this->canCreate() ) {
            return \pockets::error("Denied");
        }

        if( !is_string( $this->resource ) ) {
            return \pockets::error("Resource must be a string.");
        }
        
        if ( !is_subclass_of( $this->resource, 'wc_product' ) ) {
            return \pockets::error("Invalid class");
        }

        $this->resource = new $this->resource;

        /**
            Save once so that an ID is assigned.
        */
        $this->resource->save();

        return $this->update( $update, $read );

    }

    function read( array $read ) : mixed {
        
        if( !$this->canRead() ) {
            return \pockets::error( "Denied");
        }

        return $this->read_resource( $read );

    }

    function update( array $update, array | bool $read ) : bool | array | \WP_Error {

        if( !$this->canUpdate() ) {
            return \pockets::error( "Denied");
        }

        $updated = $this->update_resource( $update );
        
        $this->resource->save();

        wc_delete_product_transients( $this->resource->get_id() );

        if( $read === false ) {
            return $updated;
        }

        return $this->read( $read );

    }
    
    function delete( array $delete ) : bool | \WP_Error {
        return \pockets::error("Denied");
    }

}