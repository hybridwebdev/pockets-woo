<div class='p-2'>
    <label class='grid-info'>
        <span>Type</span>
        <select v-model='node.data.type' class='form-control' @change='hydrate.active'>
            <?php
                array_map(
                    array: \pockets_woo\nodes\partials_loader\node::getAvailablePartials(),
                    callback: fn( $option ) => printf(
                        <<<HTML
                            <option value='%s'>
                                %s
                            </option>
                        HTML,
                        $option['value'],
                        $option['text']
                    )
                ) 
            ?>
        </select>
    </label>
</div>