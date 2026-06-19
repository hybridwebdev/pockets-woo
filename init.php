<?php

/*
 * Plugin Name: Pockets Woo
 * Description: A Pockets extension that enhances woo functionality
 * Version:     .99
 * Author:      Hybrid Web Dev
 * Author URI:  hybridwebdev.com
 * License:     Private
 * Requires PHP: 8
 * Requires at least: 6 
 */

namespace pockets_woo {
   
   #[\AllowDynamicProperties]
   class base {

      static function init(...$args) {
         return new static(...$args);
      }

      function __construct(){
         
         $this->pluginFile = __FILE__;
			$this->dir = plugin_dir_path( $this->pluginFile );
			$this->url = plugin_dir_url( $this->pluginFile );

      }
      
   }
   
   add_filter('pockets/template-locations', fn( array $templates ) => array_merge(
      $templates,
      [ base::init()->dir ],
   ), 1 );

   add_action('plugins_loaded', function(){

      if( !class_exists("\pockets\base" ) ) {

         add_action( 'admin_notices', function(){

            echo <<<HTML
                  <div class="notice notice-error is-dismissible">
                        <p>Pockets Woo requires the Pockets plugin.</p>
                  </div>
            HTML;
         
         });

      }

      if( class_exists("\pockets\base" ) ) {
      
         \pockets\autoloader::register( plugin_dir_path( __FILE__ ), __NAMESPACE__ );

         plugin\module::init();

      }
      
   }, 100 );

}
