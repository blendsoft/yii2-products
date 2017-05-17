<?php

namespace app\modules\products\models;

use app\components\behaviors\TreeBehavior;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;

class ProductCategory extends Tree {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();
        $rules[] = ['product_attributes', 'safe'];
        return $rules;
    }

    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    [
                        'class' => TreeBehavior::className(),
                    ],
        ]);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (is_array($this->product_attributes)) {
                $this->product_attributes = \yii\helpers\Json::encode($this->product_attributes);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterFind() {
        $this->product_attributes = \yii\helpers\Json::decode($this->product_attributes);
        parent::afterFind();
    }

    public static function getIdsArray($query) {
        $cats = $query->asArray()->all();
        $arr = [];
        foreach ($cats as $cat) {
            $arr[] = $cat['id'];
        }
        return $arr;
    }

    public static function getIdsString($query) {
        $cats = $query->asArray()->all();
        $s = '';
        foreach ($cats as $cat) {
            $s .= $cat['id'] . ',';
        }
        return $s;
    }

    /**
     * Override isDisabled method if you need as shown in the  
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
//    public function isDisabled()
//    {
//        if (Yii::$app->user->username !== 'admin') {
//            return true;
//        }
//        return parent::isDisabled();
//    }
}
