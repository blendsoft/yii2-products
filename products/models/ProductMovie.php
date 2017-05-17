<?php

namespace app\modules\products\models;

/**
 * Description of ProductMovie
 *
 * @author darek
 */
use MediaEmbed\MediaEmbed;
use yii\helpers\Html;

class ProductMovie extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'product_movie';
    }

    public function rules() {
        return [
            [['name', 'link'], 'required'],
        ];
    }

    public function getThumb() {
        $em = new MediaEmbed();
        $info = $em->parseUrl($this->link);
        if ($info != null) {
            return Html::img($info->image(), ['class' => 'img-responsive']);
        }
    }

    public function getThumbUrl() {
        $em = new MediaEmbed();
        $info = $em->parseUrl($this->link);
        if ($info != null) {
            return $info->image();
        }
    }

    public function getEmbed() {
        $em = new MediaEmbed();
        $info = $em->parseUrl($this->link);
        if ($info != null) {
            return $info->getEmbedCode();
        }
    }

    public function getVideoId() {
        $em = new MediaEmbed();
        $info = $em->parseUrl($this->link);
        if ($info != null) {
            return $info->id();
        }
    }

    public function getDBVideoId() {
        return $this->videoid;
    }

    public function getDBThumb() {
        return $this->thumb;
    }

    public function getName() {
        return $this->name;
    }

}
