<?php 
namespace pockets_woo\nodes\partials;

class node extends \pockets_node_tree\nodes\node {

    public $edit_fields = [
        
    ];

    public function getSchema(){

        return [
            "fields" => [ 'base-attributes', 'style', 'bootstrap-styling' ],
            "title" => "Woo Partials",
            'group' => "Woocommerce",
            "node" => [
                "el" => "div",
                "props" => [
                    "class" => "",
                    'innerHTML' => ""
                ],
                'data' => [
                    'type' => "notice-wrapper"
                ],
                "schema" => "woo-partials"
            ]
        ];
        
    }

    function hydrate( $node ){
        
        
        ob_start();
        woocommerce_output_all_notices();
        $content = ob_get_clean();
        $node['props']['innerHTML'] = $content;
        return $node;

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
