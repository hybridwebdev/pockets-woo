<?php 
namespace pockets_woo\template_hooks;

class global_cleanup {

    use \pockets\traits\init;

    function __construct(){

        add_action( 'wp_enqueue_scripts', function() {

                wp_dequeue_script( 'selectWoo' );
                wp_dequeue_script( 'select2' );
                wp_dequeue_script( 'wc-selectWoo' );
                wp_dequeue_style( 'select2' );

        }, 100 );
        
        add_filter( 'woocommerce_form_field', function( $field ) {

            return str_replace( 
                search: ['input-text', 'form-row-first', 'form-row-last', 'form-row', 'wc-enhanced-select'], 
                replace: '', 
                subject: $field 
            );

        }, 10 );
                
        add_filter( 'woocommerce_form_field_args', function( $args, $key ) {

            $CB = match( $args['type'] ) {
                default => false,
                'state', 'country', 'tel', 'email', 'textarea', 'text' => function() use ( $args ) {
                    $args['class'] = ['grid', 'columns-1', 'gap-1', 'm-0'];
                    $args['input_class'] = [ 'form-control' ];
                    return $args;
                }
            };

            if( $CB ) {
                $args = $CB();
            }

            return $args;

        }, 10, 2 );
 
    }


}
