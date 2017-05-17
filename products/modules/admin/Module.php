<?php

namespace app\modules\products\modules\admin;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\products\modules\admin\controllers';
    public $layout = '@app/modules/admin/views/layouts/admin';

    public function init() {
        parent::init();
        Yii::$app->language = 'pl';
       
    }

}
