<?php
namespace pockets_woo\crud\models\woo\products;
 
/**
    This class is used to sync data with the web_users azure DB table.
*/

class model extends \pockets\crud\model {
    
    static string $model_name = 'woo/products';
    
    public string $read_resource = __NAMESPACE__.'\read';
    public string $get_resource = __NAMESPACE__.'\get';

    use permissions;
 
    function create( array $read, array $update ) : bool | \WP_Error {
        
        if( !$this->canCreate() ) {
            return \pockets::error("Denied");
        }

        return [];

    }

    function read( array $read ) : mixed {
        
        return $this->read_resource( $read );

    }

    function update( array $update, array $read ) : bool | \WP_Error {
        return \pockets::error("Couldn't update");
    }
    
    function delete( array $delete ) : bool | \WP_Error {
        return \pockets::error("Denied");
    }

}