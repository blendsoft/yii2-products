<?php

namespace app\modules\products\widgets;

use app\modules\products\models\Product;
use yii\base\Widget;

/**
 * Description of UserProducts
 *
 * @author darek
 */
class PromotedProducts extends Widget {

    public $model = null;

    public function init() {
        parent::init();
    }

    public function run() {


        $models = Product::find()->promoted()->limit(4)->all();
//        $first = isset($models[0]) ? $models[0] : null;
//        $models = \yii\helpers\ArrayHelper::remove($array, 0);

        return $this->render('promoted_products', [
                    //'first' => $first,
                    'models' => $models,
        ]);
    }

}
