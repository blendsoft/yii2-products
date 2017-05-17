<?php

namespace app\modules\products\controllers;

/**
 * Description of ProductImageController
 *
 * @author darek
 */
use Yii;
use app\modules\products\models\ProductImage;
use Intervention\Image\ImageManager;
use yii\helpers\Inflector;
use yii\web\Response;
use yii\helpers\Json;

class ProductImageController extends \yii\web\Controller {

    public function actionImage($pid, $id, $width = null, $height = null) {

        $slug = Inflector::slug(ProductImage::className(), '_');
        $file = Yii::getAlias('@webroot/uploads/' . $slug . '/' . $pid . '/org_' . $id . '.jpg');

        $manager = new ImageManager(['driver' => 'gd', 'cache' => ['path' => 'cache/']]);

        $img = $manager->cache(function($image) use ($file, $width, $height) {
            $image->make($file);
            if (null !== $width or null !== $height) {

                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
        }, 525600, true);

        Yii::$app->response->format = Response::FORMAT_RAW;
        echo $img->response('jpg', 90);
    }

    public function actionImageCropped($pid, $id, $width = null, $height = null) {

        $slug = Inflector::slug(ProductImage::className(), '_');
        $file = Yii::getAlias('@webroot/uploads/' . $slug . '/' . $pid . '/org_' . $id . '.jpg');

        $manager = new ImageManager(['driver' => 'gd', 'cache' => ['path' => 'cache/']]);

        $img = $manager->cache(function($image) use ($file, $width, $height) {
            $image->make($file);
            if (null !== $width or null !== $height) {
                $image->fit($width, $height);
            }
        }, 525600, true);

        Yii::$app->response->format = Response::FORMAT_RAW;
        echo $img->response('jpg', 90);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->delete();
        echo Json::encode([]);
    }

    protected function findModel($id) {
        if (($model = ProductImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
