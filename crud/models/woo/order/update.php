<?php
namespace pockets_woo\crud\models\woo\order;

class update extends \pockets\crud\resource_walker {
    
    /**
        Looks at order items to see if they were added
        via the jobsDashboard. Any items added via that method
        will be updated with the woos order ID
    */
    function jobItemOrderIDS() : string | bool {
        
        array_map(
            array: $this->resource->get_items(),
            callback: function( $item ){
                
                $data = \pockets::crud('woo/order/item')::init( $item )->read( [
                    'meta' => "jobDashboard"
                ] );

                if( !is_array( $data['meta'] ) ) {
                    return;
                }

                if( !($data['meta']['jobItemID'] ?? false) ) {
                    return;
                }

                $item = \pockets::crud('job-dashboard/job-item')::init( $data['meta']['jobItemID'] )->update([
                    'data' => [
                        'order_id' =>  $this->resource->get_id(),
                    ]
                ], false );

            }
        );

        return true;

    }
     
}