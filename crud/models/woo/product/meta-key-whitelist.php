<?php
namespace pockets_woo\crud\models\woo\product;

class meta_key_whitelist {
    
    /**
        List of meta keys that can be updated/read from 
    */
    static function getKeys(){
        
        $projectKeys = [

            /**
                This one is vital. Do not remove.
            */
            'azure_import_ID',

            'productClass',
            'group',
            'productType',
            'size',
            'signal',
            'showPrice',
            'hidePublic',
            'hideTrade',
            'clearance',
            'lastUpdated',
            'isDiscounted',
            'associatedSKU',
            'PriceRRP',
            'PriceDefault',
        ];

        return $projectKeys + [
            
            '_price',
            '_stock',
            '_regular_price',
            '_sale_price',
            '_sku'

        ];

    }

}