<?php 
namespace pockets_woo\template_hooks;

class global_cleanup {

    use \pockets\traits\init;

    function __construct(){

        add_action( 'wp_enqueue_scripts', function() {

            wp_dequeue_script( 'selectWoo' );

        }, 100 );

        add_filter( 'woocommerce_form_field', function( $field, $key, $args ) {
            
            if( !empty( $args['process-form-field'] ) ) {
            
                $field = str_replace( 
                    search: [ 'input-text', "wc-enhanced-select", 'form-row-wide', 'form-row-first', 'form-row-last', 'form-row' ], 
                    replace: '', 
                    subject: $field 
                );

                $field = sprintf( "<div style='order: %s'>%s</div>", (int)($args['priority'] ?? 0), $field );

            }
            
            return $field;

        }, 10, 3 );
                
        add_filter( 'woocommerce_form_field_args', function( $args, $key ) {

            // \pockets::dump( $args );
            $CB = match( $args['type'] ) {
                
                default => false,
                
                'state', 
                'country', 
                'tel', 
                'email', 
                'textarea', 
                'text' => function() use ( $args ) {

                    $args['class'] = array_merge( $args['class'], [ 'grid', 'columns-1', 'gap-1', 'm-0' ] );
                    $args['input_class'] = array_merge( $args['input_class'], [ 'form-control' ] );
                    $args['process-form-field'] = true;
                    
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
