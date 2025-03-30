<?php
namespace pockets_woo\crud\models\woo\product;

trait permissions {

    function canCreate() : bool {

        if( !current_user_can('administrator') ) {
            return false;
        }

        return true; 

    }

    function canRead() : bool {

        return $this->validate_resource();
        
    }

    function canUpdate() : bool {

        if( !current_user_can('administrator') ) {
            return false;
        }

        return $this->validate_resource();
        
    }

    function canDelete() : bool {

        if( !current_user_can('administrator') ) {
            return false;
        }

        return $this->validate_resource();
        
    }

    function validate_resource(){

        if ( is_subclass_of( $this->resource, 'wc_product' ) ) {
            return true;
        }

        return false;

    }

}
