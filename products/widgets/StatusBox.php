<?php
namespace app\modules\products\widgets;

use yii\base\Widget;

class StatusBox extends Widget {

    public $model = null;

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('status_box', ['model' => $this->model]);
    }

}
