<?php 
namespace pockets_woo\nodes\shop_partials_loader;

class node extends \pockets_node_tree\nodes\template_loader\node {

    use \pockets_woo\nodes\partials_loader;

    public $edit_fields = [
        [
            'ID'=> "woo-shop-partials-loader-settings",
            'content'=> [ 
                'template' => 'pockets-node-tree/nodes/template-loader/fields/template-selector',
                'static_template_type' => "woo-shop-template"
            ],
            'group'=> "Edit" 
        ],
    ];

    public function getSchema(){

        return [
            "title" => "Shop Templates",
            'group' => "Woocommerce",
            "fields" => [ 
                'base-attributes', 'el-selector', 'woo-shop-partials-loader-settings', 'data', 'style', 'bootstrap-styling' 
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
                "schema" => "woo-shop-partials-loader"
            ]

        ];
        
    }
    
    function innerHTML( $node ) : string {
        
        $queried_object = get_queried_object();
        
        $html = 'No template selected';

        if( $node->get('data.template' ) ) {
            
            $html = \pockets::crud( 'crud-resource' )::init( $queried_object )->read( [
                'render' => $node->get( 'data' )
            ] )['render'];
            
        }
        
        if( is_wp_error( $html ) ) {
            $html = $html->get_error_message();
        };

        return $html;

    }

}
