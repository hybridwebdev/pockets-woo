<?php 
namespace pockets_woo\nodes\cart_partials_loader;

class node extends \pockets_node_tree\nodes\template_loader\node {

    public $edit_fields = [
        [
            'ID'=> "woo-cart-partials-loader-settings",
            'content'=> [ 
                'template' => 'pockets-node-tree/nodes/template-loader/fields/template-selector',
                'static_template_type' => "woo-cart-template"
            ],
            'group'=> "Edit" 
        ],
    ];

    public function getSchema(){

        return [
            "title" => "Cart Templates",
            'group' => "Woocommerce",
            "fields" => [ 
                'base-attributes', 'el-selector', 'woo-cart-partials-loader-settings', 'data', 'style', 'bootstrap-styling' 
            ],
            
            "elTypes" => [ 
                "div", 
                "render-html" 
            ],

            "node" => [
                "el" => "render-html",
                'data' => [
                    'template' => false,
                    'style' => ""
                ],
                "props" => [
                    "class" => "col-12",
                ],
                "schema" => "woo-cart-partials-loader"
            ]

        ];
        
    }
    
    function hydrate( $node ){
        
        $html = 'No template selected';

        if( $node['data']['template'] ) {
            
            $html = \pockets::crud( 'woo/cart' )::init([])->read( [
                'render' => $node['data']
            ] )['render'];
            
        }
        
        if( is_wp_error( $html ) ) {
            $html = $html->get_error_message();
        };

        $node['props']['innerHTML'] = $html;
        
        return $node;

    }

}
