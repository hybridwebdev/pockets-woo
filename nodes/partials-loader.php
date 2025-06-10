<?php 
namespace pockets_woo\nodes;

trait partials_loader {

    function sanitize( $node ){
        
        $node->wp_parse_args( 'data', $this->schema->get( 'node.data' ) );
        $node->wp_parse_args( 'props', $this->schema->get( 'node.props' ) );

        $node = static::node_sanitizer( $node->all() );

        $node->rules
            ->path( 'data.*', [ 'template', 'style' ] )->sanitize( 'walk_array' )
            ->path( "data.template" )->sanitize( 'template_path' )
            ->path( "data.style" )->sanitize( 'style' )
            ->path( 'props.innerHTML' )->sanitize( 'template_html' )
            ->path( 'data' )->sanitize( 'array' )
        ;
        
        $node->sanitizePath( "data.*" );
        $node->set( 'props.innerHTML', $this->innerHTML( $node ) );
        
        return $node->sanitize()->data;

    }
        
    function save( $node ) {

        $node->delete( 'props.innerHTML' );
        return $node->all();

    }

    abstract function innerHTML( $node ) : string;

}