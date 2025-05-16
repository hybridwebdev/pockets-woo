<?php 
namespace pockets_woo\template_hooks;

class fix_woo_main_query {
    
    use \pockets\traits\init;
    
    function __construct(){

        // add_filter( 'query_vars', function($vas){
        //     return $vas;
        // }, 0 );

        // remove_action( 'pre_get_posts', [ WC()->query, 'pre_get_posts' ], 10 );
        // remove_action( 'parse_request', [ WC()->query, 'parse_request' ], 0 );


        // add_filter( 'query_vars', function( $vars ){
        //     $vars[] = 'orderby';
        //     //$vars[] = 'order';
        //     return $vars;

        // }, 100 );

        add_action('pre_get_posts', function( $query ){
            if( \pockets::is_rest_request() && $query->is_main_query() ) {
                //\pockets::dump( $query );
                // echo "Pre_get_posts";
                // \pockets::dump( [\pockets\queried_object\context::$simulatedUrl, get_query_var( 'orderby' )] );
                // //\pockets::dump(get_query_var('orderby'));

                // if( !$query->is_main_query() || !is_shop() ) {
                //     return;
                // }
                // $args = $this->get_wp_query_vars_from_url( \pockets\queried_object\context::$simulatedUrl );

                // if( $args['orderby']) {
                //     //$query->set( 'orderby', $args['orderby'] );
                // }
              
            }

        }, 11 );

    }

    function get_wp_query_vars_from_url( $url ) {

        $allowed_vars = apply_filters( 'woocommerce_get_query_vars', [ 'orderby', 'search', 's', 'order' ] );

        $query_string = parse_url( $url, PHP_URL_QUERY );
        parse_str( $query_string, $query_vars );

        $wp_query_vars = array_filter(
            $query_vars,
            fn( $key ) => in_array( $key, $allowed_vars, true ),
            ARRAY_FILTER_USE_KEY
        );

        return $wp_query_vars;

    }

}







class module {

    use \pockets\traits\init;

    function __construct(){
        
        single_product::init();
        checkout_form::init();
        fix_woo_main_query::init();

    }

}
