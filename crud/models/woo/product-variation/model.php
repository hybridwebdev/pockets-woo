<?php
namespace pockets_woo\crud\models\woo\product_variation;

class model extends \pockets_woo\crud\models\woo\product\model {
    
    static string $model_name = 'woo/product/variation';
    
    public string $read_resource = '\pockets\crud\models\woo\product\read';
    public string $update_resource = '\pockets\crud\models\woo\product\update';
    public string $get_resource = __NAMESPACE__.'\get';
  
}