<?php

namespace app\modules\products\models;

use app\components\fieldTypes\BaseType;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

/**
 * Description of ProductAttribute
 *
 * @author darek
 */
class ProductAttribute extends ActiveRecord {

    public function rules() {
        return [
            [['name', 'field_type'], 'required'],
        ];
    }

    public function getFieldType() {
        $base = new BaseType();
        if (isset($base::$fieldTypes[$this->field_type])) {
            return $base::$fieldTypes[$this->field_type];
        }
    }

    public function getFormField(ActiveForm $form, ProductAttribute $model, Product $owner) {

        $base = new BaseType();

        if (isset($base::$fieldClasses[$this->field_type])) {

            $class = $base::$fieldClasses[$this->field_type];
            $field = new $class;

            if ($field instanceof BaseType) {

                $pa = ProductAttributes::findOne(['attribute_id' => $model->id, 'product_id' => $owner->id]);
                if (null != $pa) {
                    
                } else {
                    $pa = new ProductAttributes();
                    $pa->attribute_id = $model->id;
                    $pa->product_id = $owner->id;
                }

                return $field->getFieldFormDefinition($form, $pa);
            }

            //getFieldFormDefinition()
            //var_dump($field);
        } else {
            $field = new BaseType();
            $pa = ProductAttributes::findOne(['attribute_id' => $model->id, 'product_id' => $owner->id]);
            if (null != $pa) {
                
            } else {
                $pa = new ProductAttributes();
                $pa->attribute_id = $model->id;
                $pa->product_id = $owner->id;
            }

            return $field->getFieldFormDefinition($form, $pa);
        }
    }

    public function search($params) {

        $query = ProductAttribute::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function getName() {
        return $this->name;
    }

}
