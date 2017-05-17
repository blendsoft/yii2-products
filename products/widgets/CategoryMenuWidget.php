<?php

/**
 * Description of CategoryMenuWidget
 *
 * @author darek
 */

namespace app\modules\products\widgets;

use app\modules\products\models\ProductCategory;
use yii\base\Widget;

class CategoryMenuWidget extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        
        $tree = $this->getMenuArray();
        //print_r($tree);
        return $this->render('category_menu', ['tree' => $tree]);
    }

    function createTree($category, $left = 0, $right = null) {
        $tree = array();
        foreach ($category as $cat => $range) {
            if ($range['lft'] == $left + 1 && (is_null($right) || $range['rgt'] < $right)) {
                $tree[$cat]['label'] = $range['name'];
                $tree[$cat]['url'] = ['/products/product/index', 'category_id' => $range['id']];              
                $items =  $this->createTree($category, $range['lft'], $range['rgt']); 
                //var_dump($items);
                $tree[$cat]['items'] = $items;
                if (empty($items) === true) {                                       
                    $tree[$cat]['template'] = '<a class="" href="{url}"><span class="fa"></span><span class="sidebar-title">{label}</span></a>';  
                }
                
                $left = $range['rgt'];
            }
        }
        
        return $tree;
    }

    public function getMenuArray() {
        $roots = ProductCategory::find()->where('lvl >= 1')->addOrderBy('root, lft')->asArray()->all();
        $tree = $this->createTree($roots, 1);
        return $tree;
    }

}
