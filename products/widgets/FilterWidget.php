<?php

namespace app\modules\products\widgets;

use app\modules\products\models\FilterForm;
use yii\base\Widget;

/**
 * Description of FilterWidget
 *
 * @author darek
 */
class FilterWidget extends Widget {

    public $search = null;

    public function init() {
        parent::init();
    }

    public function run() {
        $model = new FilterForm();

        if (null != $this->search) {
            $model->tmpSoftwares = $this->search->tmpSoftwares;
            $model->tmpFormats = $this->search->tmpFormats;
        }
        return $this->render('filter_widget', ['model' => $model]);
    }

}
