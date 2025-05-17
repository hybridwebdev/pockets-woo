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
<pockets-route-state #default='{ query: search }'>
    {{ search }}
    <pockets-temp-state
        v-model:state="search"
        #default="{ state:params, update, hasChanges }"
        :key='Date.now()'
    >
        <form 
            @submit.prevent='() => {
                Object.assign(search, params)
            }'
        >
            <div class='grid columns-3 gap-1'>
                
                <label class='grid-card-2'>
                    <span>Order</span>
                    <select class='form-control' v-model='params.orderby' @change='() => {
                            Object.assign(search, params)
                        }'>
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