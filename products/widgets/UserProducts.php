<?php

namespace app\modules\products\widgets;
use app\modules\products\models\ProductSearch;
use yii\base\Widget;



/**
 * Description of UserProducts
 *
 * @author darek
 */
class UserProducts extends Widget {

    public $model = null;

    public function init() {
        parent::init();
    }

    public function run() {

        $search = new ProductSearch();
        $search->user_id = $this->model->id;
        return $this->render('user_products', [
                    'model' => $this->model,
                    'search' => $search,
        ]);
    }

}
