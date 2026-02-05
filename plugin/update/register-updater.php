<?php
namespace pockets_woo\plugin\update;

/**
    Class registers an updater for this plugin. Should extend a plugin instance so that it has:
        $this->url, $this->dir, $this->pluginFile
    See the base class this extends for implementation.
*/
#[\AllowDynamicProperties]
class register_updater extends \pockets_woo\base {

    use \pockets\utils\updaters\plugin\base;
    
    function getOptions() : array {
        
        $options = get_option('pockets/updater');
        
        return $options + [
            'repository' => "hybridwebdev/pockets-woo",
            'transientKey' => "pockets-woo-updater",
        ];

    }  

    function modify_response( string $action, \pockets\utils\array_dot_prop $response ) : \pockets\utils\array_dot_prop {

        $response->set( 'tested', 7.0 );

        // $response->set('icons', [
        //     '1x' => "{$this->url}/assets/images/pockets-725x375.jpg",
        //     '2x' => "{$this->url}/assets/images/pockets-725x375.jpg",
        // ] );

        if( $action == 'info' ) {
            
            $response->set( 'donate_link', 'hybridwebdev.com' );
            $response->set( 'sections.installation', 'Install it like any other plugin. Activate. ' );

        }

        return $response;

    }
   
}
