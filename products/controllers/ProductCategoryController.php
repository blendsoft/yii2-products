<?php

/**
 * Description of ProductCategoryController
 *
 * @author darek
 */
namespace app\modules\products\controllers;

use yii\web\Controller;

class ProductCategoryController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

}
