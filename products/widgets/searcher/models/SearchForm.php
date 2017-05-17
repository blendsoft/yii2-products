<?php

namespace app\modules\products\widgets\searcher\models;

use yii\base\Model;

/**
 * Description of FilterForm
 *
 * @author darek
 */
class SearchForm extends Model {

    public $keyword;

    public function rules() {
        return [
            //    [['tmpSoftwares', 'tmpFormats'], 'safe'],
            [['keyword'], 'safe'],
        ];
    }

}
