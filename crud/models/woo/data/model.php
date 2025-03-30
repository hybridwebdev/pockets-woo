<?php
namespace pockets_woo\crud\models\woo\data;

class model extends \pockets\crud\model {

    static string $model_name = 'woo/data';
    public string $update_resource = __NAMESPACE__.'\update';
    public string $read_resource = __NAMESPACE__.'\read';
 
    function create( array $read, array $update ) : bool | \WP_Error {
        return \pockets::error("Denied");
    }

    function read( array $query ) : \WP_Error | array {
        return $this->read_resource( $query );
    }

    function update( array $update, array | bool $read )   {
        
        $updated = $this->update_resource( $update );
        
        if( !$read ) {
            return $updated;
        }

        return $this->read( $read );

    }
    
    function delete( array $delete ) : bool | \WP_Error {
        return \pockets::error("Denied");
    }

}