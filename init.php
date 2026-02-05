<?php

/*
 * Plugin Name: Pockets Woo
 * Description: Woo
 * Version:     .99
 * Author:      Justin L
 * Author URI:  justin
 * License:     Private
 * Requires PHP: 8
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
      \pockets\autoloader::register( plugin_dir_path( __FILE__ ), __NAMESPACE__ );
      plugin\module::init();
   }, 100 );

}
