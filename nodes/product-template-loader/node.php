<?php 
namespace pockets_woo\nodes\product_template_loader;

class node extends \pockets_node_tree\nodes\template_loader\node {

    public $edit_fields = [
        [
            'ID'=> "woo-product-template-loader-settings",
            'content'=> [ 
                'template' => 'pockets-node-tree/nodes/template-loader/fields/template-selector',
                'static_template_type' => "woo-product-template"
            ],
            'group'=> "Edit" 
        ],
    ];

    public function getSchema(){

        return [
            "title" => "Woo Product Templates",
            'group' => "Woocommerce",
            "fields" => [ 
                'base-attributes', 'el-selector', 'woo-product-template-loader-settings', 'data', 'style', 'bootstrap-styling' 
            ],
            
            "elTypes" => [ 
                "div", 
                "render-html" 
            ],

            "node" => [
                "el" => "render-html",
                'data' => [
                    'template' => false,
                ],
                "props" => [
                    "class" => "col-12",
                ],
                "schema" => "woo-product-template-loader"
            ]

        ];
        
    }
 

}
