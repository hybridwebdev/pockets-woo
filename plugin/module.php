<?php
namespace pockets_woo\plugin;

/**
    Bootloader for Pockets Form extension
*/

#[\AllowDynamicProperties]
class module extends \pockets_forms\base {

    use \pockets\traits\init;

    function __construct(){
        
        parent::__construct();

        api\module::init();

    }
    
}
