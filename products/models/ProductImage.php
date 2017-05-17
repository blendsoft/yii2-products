<?php

namespace app\modules\products\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use Intervention\Image\ImageManager;
use app\helpers\Filesystem;
use yii\helpers\Inflector;
use app\components\behaviors\Image;

/**
 * This is the model class for table "product_image".
 *
 * @property integer $id
 * @property string $file
 * @property integer $product_id
 * @property integer $created
 * @property integer $updated
 *
 * @property Product $product
 */
class ProductImage extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_image';
    }

    public function behaviors() {
        return
                [
                    [
                        'class' => TimestampBehavior::className(),
                        'createdAtAttribute' => 'created',
                        'updatedAtAttribute' => 'updated',
                    ],
                    [
                        'class' => Image::className(),
                    ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['file', 'product_id', 'created', 'updated'], 'required'],
            [['product_id', 'created', 'updated'], 'integer'],
            [['file'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'file' => Yii::t('app', 'File'),
            'product_id' => Yii::t('app', 'Product ID'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return ProductImageQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProductImageQuery(get_called_class());
    }

    public function upload() {

        $slug = Inflector::slug(self::className(), '_');

        $path = Yii::getAlias('@webroot/uploads/' . $slug . '/' . $this->product_id);
        Filesystem::checkCreateDirectory($path);
        $file = $this->file->tempName;

        $fileOut = Yii::getAlias('@webroot/uploads/' . $slug . '/' . $this->product_id . '/org_' . $this->id . '.' . 'jpg');
        $manager = new ImageManager(['driver' => 'gd', 'cache' => ['path' => 'cache/']]);
        $manager->make($file)->save($fileOut, 100);
        $this->file = $this->id . '.jpg';

        return true;
    }

}
