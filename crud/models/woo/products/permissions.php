<?php
namespace pockets_woo\crud\models\woo\products;

trait permissions {

    function canCreate() : bool {
        return $this->validate_resource();
    }

    function canRead() : bool {
        return $this->validate_resource();
    }

    function canUpdate() : bool {
        return $this->validate_resource();
    }

    function canDelete() : bool {
        return $this->validate_resource();
    }

    function validate_resource(){
        return $this->resource instanceof \WP_User;
    }

}
