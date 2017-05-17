<?php

namespace app\modules\products\models;

/**
 * Description of ProductAttributes
 *
 * @author darek
 */
use app\modules\products\models\ProductAttribute;

class ProductAttributes extends \yii\db\ActiveRecord {

    public function rules() {
        return [
            [['value_string'], 'safe'],
        ];
    }

    public function getType() {
        return $this->hasOne(ProductAttribute::className(), ['id' => 'attribute_id']);
    }

    public function getTypeName() {
        if (isset($this->type) === true) {
            return $this->type->name_id;
        }
    }

    public function getProductAttribute() {
        return $this->hasOne(ProductAttribute::className(), ['id' => 'attribute_id']);
    }

    public function getProductAttributeLabel() {
        if (isset($this->productAttribute)) {
            return $this->productAttribute->getName() . '';
        } else {
            
        }
    }

}
