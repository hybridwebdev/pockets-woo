<?php
namespace pockets_woo\plugin;

/**
    Bootloader for Pockets Form extension
*/

class route_filters {

    use \pockets\traits\initOnce;

    function __construct(){
        add_filter('pockets-node-tree/router/read/document_tree_source/wp_post_type', [$this, 'wp_post_type'], 10, 2);
    }

    
    function wp_post_type( $source, $resource ){

        $d =  $resource->read( [ "crud_resource" ] );

        if( $d['crud_resource']['name'] == 'product') {

            return \pockets::crud('post')::init( wc_get_page_id('shop') )->read( [
                'crud_resource'
            ] ) + [
                'metaKey' => "body"
            ];

        }

        return $source;
        
    }

}
