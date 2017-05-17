<?php
namespace app\modules\products\widgets\searcher;

use app\modules\products\widgets\searcher\models\SearchForm;
use yii\base\Widget;


class SearcherWidget extends Widget {
  
    public function init() {
        parent::init();
    }

    public function run() {       
        $model = new SearchForm();
        return $this->render('searcher_widget', ['model' => $model]);
    }

}
