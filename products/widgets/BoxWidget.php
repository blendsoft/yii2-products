<?php
namespace app\modules\products\widgets;

use yii\base\Widget;

class BoxWidget extends Widget {

    public $model = null;

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('box_widget', ['model' => $this->model]);
    }

}
