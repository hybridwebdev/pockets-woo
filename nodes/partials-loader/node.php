<?php 
namespace pockets_woo\nodes\partials_loader;

/**
    You can add a new partial by applying a filter via the static $getAvailablePartials property name.
    The function should return an array like so:
    [
        'text' => "Text to show in the select field when choosing a partial in the editor",
        'value' => "should be a text value that is unique for the partial.",
        'callback' => function( $node ) {

            should a callback that handles how the nodes innerHTML is generated.
            $node will be an array_dot_prop wrapped instance of the node.
            
        }
    ]
*/

trait getAvailablePartials {

    /**
        Hook name for apply_filters for getAvailablePartials function  
    */
    
    static function getAvailablePartials() : array {
        return apply_filters( static::$getAvailablePartials, [] );
    }

    static $getAvailablePartials = "pockets_woo/nodes/partials_loader/getAvailablePartials";

}

class node extends \pockets_node_tree\nodes\node {

    use getAvailablePartials;

    public $edit_fields = [
         [
            'ID'=> "woo-partials/data-type",
            'content'=> [ 'template' => 'pockets-woo/nodes/partials-loader/fields/edit' ],
            'group' => "Edit"
        ],
    ];

    public function getSchema(){

        return [
            "fields" => [ 'base-attributes', 'style', 'bootstrap-styling', 'woo-partials/data-type' ],
            "title" => "Woo Partials",
            'group' => "Woocommerce",
            "node" => [
                "el" => "render-html",
                "props" => [
                    "class" => "",
                    'innerHTML' => ""
                ],
                'data' => [
                    'type' => "single-product/add-to-cart"
                ],
                "schema" => "woo-partials"
            ]
        ];
        
    }

    function hydrate( $node ){

        $node = $this->array_dot_prop( $node );

        /**
        
            Aggregate registered partials list and look for their callbacks.
            Used to map node.data.type value to the corresponding handler. 
            If handler is not found or is not a function, a fallback will be
            used.

        */
        $callbacks = array_reduce(
            array: static::getAvailablePartials(),
            callback: function( $acc, $partial ){
                $acc->set( $partial['value'], $partial['render'] );
                return $acc;
            },
            initial: $this->array_dot_prop([])
        );

        $render = $callbacks->get( $node->get( 'data.type', false ), false );

        if( !$render || !is_callable( $render ) ) {

            $render = function(){
               echo "Invalid Partial type";
            };

        }

        ob_start();
        
        /**
         
            Render is invoked and whatever it echoes out is used to generate
            the nodes innerHTML. 

        */
        $render( $node );

        $node->set( 'props.innerHTML', ob_get_clean() );

        return $node->all();

    }

    function render($node){

        /**
            When rendering, force div because render-html would be redundant as
            compiling is handled via pockets-app instead of the editor context.
        */
        if( $node['el'] == 'render-html' ) {
            $node['el'] = 'div';
        }

        return [
            'open' => sprintf(
                <<<'HTML'
                    <%1$s class='%2$s'>%3$s</%1$s>
                HTML,
                $node['el'],
                $node['props']['class'],
                $node['props']['innerHTML'],
            ),
        ];

    }
     
    function save( $node ) {
        $node['props']['innerHTML'] = '';
        return $node;
    }

}
