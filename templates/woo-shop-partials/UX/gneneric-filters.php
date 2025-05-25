<?php 
/**
* Template Name: UX - Generic Filters
* Template Type: woo-shop-template
*/
$orderBy = [
  ['title' => 'Sort by popularity', 'value' => 'popularity'],
  ['title' => 'Sort by average rating', 'value' => 'rating'],
  ['title' => 'Sort by latest', 'value' => 'date'],
  ['title' => 'Sort by price: low to high', 'value' => 'price'],
  ['title' => 'Sort by price: high to low', 'value' => 'price-desc'],
  ['title' => 'Sort by name: A to Z', 'value' => 'title'],
  ['title' => 'Sort by name: Z to A', 'value' => 'title-desc'],
];

?>
<pockets-route-state #default='{ query, setQuery }'>

    <form 
        v-pockets-form-handler='{
            submit: setQuery
        }'
    >
        <div class='grid columns-3 gap-1'>
            
            <label class='grid-card-2'>
                <span>Order</span>
                <select 
                    class='form-control' 
                    name='orderby' 
                    :value='query.orderby' 
                    v-pockets-form-submit
                >
                    <option value=''>Default Sorting</option>
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
                <input  class='form-control' name='s' :value='query.s'>
            </label>
            <label class='grid-card-2'>
                <span></span>
                <button 
                    class='btn btn-accent-dk p-1'
                    type='submit'
                >
                    SEARCH
                </button>
            </label>
        </div>
    </form>

</pockets-route-state>