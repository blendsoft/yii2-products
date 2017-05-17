<?php

namespace app\modules\products\models;

/**
 * Description of ProductCompat
 *
 * @author darek
 */
class ProductGameEngine extends \yii\db\ActiveRecord {

    public function getName() {
        return $this->name;
    }

}
