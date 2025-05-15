<?php 
/**
* Template Name: UX - Generic Filters
* Template Type: woo-shop-template
*/
$orderBy = [
    [
        'value' => "price",
        'title' => "Price low - high"
    ],
    [
        'value' => "price-desc",
        'title' => "Price High - low"
    ],
];

?>
<pockets-route-state #default='{ location, search }'>
    <div>
        <select class='form-control' v-model='search.orderby'>
            <option :value='undefined' disabled>None</option>
            <?php
                array_map(
                    array: $orderBy,
                    callback: fn( $option ) => printf(
                        <<<HTML
                            <option value='%s'>%s</option>
                        HTML,
                        $option['value'],
                        $option['title']
                    )
                );
            ?>       
        </select>
        <input  class='form-control'>
        <input v-model='search.s' class='form-control'>
    </div>
</pockets-route-state>