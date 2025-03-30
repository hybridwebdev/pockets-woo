<?php
namespace pockets_woo\crud\models\woo\data;

class read extends \pockets\crud\resource_walker {
 
    function state_list( string | null $country ) : array {
        
        if( !$country ) {
            return [];
        }
        
        $states = WC()->countries->get_states( $country );
        
        if( !$states ) {
            return [];
        }
        
        return $states;

    }
    
}