<?php

namespace app\modules\products\models;

use app\components\behaviors\PermissionsBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * Description of ProductGameEngines
 *
 * @author darek
 */
class ProductGameEngines extends ActiveRecord {

    public static function tableName() {
        return 'product_game_engines';
    }

    public function behaviors() {
        return
                [

                    [
                        'class' => PermissionsBehavior::className(),
                    ],
        ];
    }

    public function rules() {
        return [
            [['product_game_engine_id', 'version'], 'required'],
            [['value_string'], 'required', 'on' => 'other-engine'],
            [['value_string'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'product_game_engine_id' => Yii::t('app', 'Engine'),
            'value_string' => Yii::t('app', 'Name'),
            'version' => Yii::t('app', 'Version'),
        ];
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getEngine() {
        return $this->hasOne(ProductGameEngine::className(), ['id' => 'product_game_engine_id']);
    }

    public function getEngineName() {
        if (null != $this->value_string) {
            return $this->value_string;
        } elseif (null != $this->engine) {
            return $this->engine->getName();
        }
    }

    public function getVersion() {
        return $this->version;
    }

}
