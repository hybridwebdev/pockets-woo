<?php
namespace pockets_woo\crud\models\woo\order;

class model extends \pockets\crud\model {
    
    static string $model_name = 'woo/order';

    public string $update_resource = __NAMESPACE__.'\update';
    public string $read_resource = __NAMESPACE__.'\read';
    public string $get_resource = __NAMESPACE__.'\get';
 
    function create( array $read, array $update ) : \WP_Error {
        return \pockets::error("Denied");
    }

    function read( array $query ) : \WP_Error | array {
        return $this->read_resource( $query );
    }

    function update( array $update, array | bool $read = false ) : \WP_Error | array {
        
        $updated = $this->update_resource( $update );
        
        if( !$read ) {
            return $updated;
        }

        return $this->read( $read );

    }
    
    function delete( array $delete ) : \WP_Error {
        return \pockets::error("Denied");
    }

}