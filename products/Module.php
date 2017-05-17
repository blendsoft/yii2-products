<?php

namespace app\modules\products;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\products\controllers';
    public $layout = '@app/themes/3d/layouts/main';
    public $layoutPath = '@app/themes/3d/layouts';

    public function init() {
        parent::init();

        $this->modules = [
            'admin' => ['class' => 'app\modules\products\modules\admin\Module']
        ];
    }

}
