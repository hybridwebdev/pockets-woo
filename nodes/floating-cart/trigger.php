<?php 
namespace pockets_woo\nodes\floating_cart;

class trigger extends \pockets_node_tree\nodes\node {

    public $edit_fields = [
        
    ];

    public function getSchema(){

        return [
            "fields" => [ 'base-attributes', 'style', 'bootstrap-styling' ],
            "title" => "Floating Cart Trigger",
            'group' => "Woocommerce",
            "node" => [
                "el" => "render-html",
                "props" => [
                    "class" => "",
                    'innerHTML' => ""
                ],
                "schema" => "woo-floating-cart-trigger"
            ]
        ];
        
    }

    function hydrate( $node ){
        
        $node['props']['innerHTML'] = \pockets::load_template([
            'template' => "cart/generic-floating-cart-trigger"
        ]);

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
