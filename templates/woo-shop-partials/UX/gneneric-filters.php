<?php 
/**
* Template Name: UX - Generic Filters
* Template Type: woo-shop-template
*/
$orderBy = [
    [
        'value' => 'id',
        'title' => "ID"
    ],
    [
        'value' => "price-asc",
        'title' => "Price low to high"
    ],
    [
        'value' => "price-desc",
        'title' => "Price high to low"
    ],
    [
        'value' => "title-desc",
        'title' => "Title Z-A"
    ],
    [
        'value' => "title-asc",
        'title' => "Title A-Z"
    ],
];

?>
<pockets-route-state #default='{ query, setQuery }'>

    <pockets-temp-state
        :state="query"
        #default="{ state:params, update, hasChanges }"
        @update:state='setQuery'
    >

        <form 
            @submit.prevent='update'
        >
            <div class='grid columns-3 gap-1'>
                
                <label class='grid-card-2'>
                    <span>Order</span>
                    <select class='form-control' v-model='params.orderby' @change='update'>
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

                <label class='grid-card-2'>
                    <span>Search</span>
                    <input  class='form-control' v-model='params.s'>
                </label>
                <label class='grid-card-2'>
                    <span></span>
                    <button 
                        class='btn btn-accent-dk p-1'
                        type='submit'
                        :disabled='!hasChanges'
                    >
                        SEARCH
                    </button>
                </label>
            </div>
        </form>

    </pockets-temp-state>

</pockets-route-state>