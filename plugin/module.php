<?php
namespace pockets_woo\plugin;

/**
    Bootloader for Pockets Form extension
*/

#[\AllowDynamicProperties]
class module extends \pockets\base {

    use \pockets\traits\init;

    function __construct(){
        
        parent::__construct();

        api\module::init();
        \pockets_woo\crud\models\woo\module::init();

        add_filter( '__woocommerce_locate_template', function( $template, $template_name, $template_path ){

            // //echo $template;

            // $path = sprintf( "%s/%s/%s", \pockets_woo\base::init()->dir, 'templates/woocommerce',  $template_name);

            // $debug = fn( $color ) => sprintf("<div class='p-4 %s'><p>%s</p><p>%s</p><p>%s</p> </div>", $color, $path, $template_path, $template_name);

            // if( file_exists($path) ){
            //     //echo $debug('bg-black text-white');
            //     return $path;
            // }

            // //echo $debug('bg-primary text-white');

            // return $template;
            
        }, 10, 3 );

    }
    
}
