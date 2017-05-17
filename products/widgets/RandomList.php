<?php

namespace app\modules\products\widgets;
use app\modules\products\models\ProductSearch;
use yii\base\Widget;



/**
 * Description of BestPricesList
 *
 * @author darek
 */
class RandomList extends Widget {

    public $count = 3;

    
    public function init() {
        parent::init();
    }

    public function run() {
        
        $search = new ProductSearch();
        return $this->render('random', ['search' => $search, 'count' => $this->count]);    
        
    }

}
