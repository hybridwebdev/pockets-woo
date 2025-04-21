<?php
namespace pockets_woo\plugin;

/**
    Bootloader for Pockets Form extension
*/

class route_filters {

    use \pockets\traits\initOnce;

    function __construct(){

        add_filter("pockets-node-tree/router/get/array_by_resolved/wp_post_type", [ $this, 'wp_post_type' ], 10, 2 );
       
    }

    /**
        Modify instance so if it's a product archive, it points to shop page instead. 
    */    
    function wp_post_type( $crudModel ){

        $source = $crudModel->read( [ 'crud_resource' ] );

        if( $source['crud_resource']['name'] == 'product' ) {
            
            return \pockets::crud('node-tree/router')::init( [
                'url' => get_permalink( wc_get_page_id( 'shop' ) )
            ] )->resource;

        }

        return $crudModel;

    }

}
