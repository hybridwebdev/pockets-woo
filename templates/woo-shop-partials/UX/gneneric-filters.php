<?php 
/**
* Template Name: UX - Generic Filters
* Template Type: woo-shop-template
*/
$orderBy = [
    [
        'value' => "price-asc",
        'title' => "Price Asc"
    ],
    [
        'value' => "price-desc",
        'title' => "Price Desc"
    ],
    [
        'value' => "title-desc",
        'title' => "Title Desc"
    ],
    [
        'value' => "title-asc",
        'title' => "Title"
    ],
];

?>
<pockets-route-state #default='{ location, search }'>
    <div class='grid columns-3 gap-1 pb-10'>
        <label>
            <span>Order BY</span>
            <select class='form-control' v-model='search.orderby'>
                <option :value='undefined'>None</option>
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
        </label>

        <label>
            <span>Search</span>
            <input  class='form-control' v-model='search.s'>
        </label>

    </div>

</pockets-route-state>