<?php
namespace pockets_woo\plugin\api {

    class module {
        /**
            Dummy module so that the namespace below can be bootloaded.
        */
        static function init(){}
    }

}

namespace pockets {
    
    class woo {

        use \pockets\traits\init;

        static function getOptions( string $key = 'all' ) {
            
            $options = [
                /**
                    If set to true, a bunch of behavior is modified to allow
                    woo to work with headless router
                */
                'apply-routing-handler' => true
            ];

            return match( $key ) {
                'all' => $options,
                default => $options[$key] ?? null
            };
        }

        /** 
            Helper function to get JUST the raw price 
            with woo's money formatting applied.
            accepts normal args that wc_price does as well as 2 additional
            flags:
            [
                If false, returns just the price without the HTML
                'as-html' => bool default false
                If true, includes currency symbol
                'include-currency' => bool default true
            ]
        */
        static function wc_price( string | float | int $price, ?array $args ) {

            $parsedArgs = wp_parse_args(
                is_array( $args ) ? $args : [],
                [
                    'as-html' => false,
                    'include-currency' => true
                ]
            );

            if( $parsedArgs['include-currency'] == false ) {
                $parsedArgs['currency'] = ' ';
            }

            $price = wc_price( $price, $parsedArgs );

            if( $parsedArgs['as-html'] == false ){
                return html_entity_decode( strip_tags( $price ) );
            }

            return $price;

        }

    }
    
}