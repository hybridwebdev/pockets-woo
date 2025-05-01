<?php 
namespace pockets_woo\nodes\partials_loader;

class node extends \pockets_node_tree\nodes\node {

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

        $handler = match( $node->get( 'data.type', false ) ){

            default => function(){
               echo "Invalid Partial type";
            },

            'cart/notices-wrapper' => function(){
                echo "Notices wrapper";
            },
            
            "single-product/add-to-cart" => function(){

                global $product;
                $product = wc_get_product ( get_queried_object_id() );
                woocommerce_template_single_add_to_cart();

            }

        };

        ob_start();
        
        $handler();

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

    static function getAvailablePartials(){
        return [
            [
                'value' => 'single-product/add-to-cart',
                'text' => "Single Product / Add To Cart"
            ],
            [
                'value' => 'cart/notices-wrapper',
                'text' => "Notices wrapper"
            ]
        ];
    }
}
