<?php

namespace app\modules\products\models;

use yii\base\Model;

/**
 * Description of FilterForm
 *
 * @author darek
 */
class FilterForm extends Model {

    public $tmpSoftwares;
    public $tmpFormats;
    public $tmpEngines;

    public function rules() {
        return [         
            [['tmpSoftwares', 'tmpFormats', 'tmpEngines'], 'integer'],
        ];
    }

}
