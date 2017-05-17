<?php

namespace app\modules\products\controllers;

/**
 * Description of ProductMovieController
 *
 * @author darek
 */
use app\modules\products\models\ProductMovie;
use app\modules\products\models\ProductMovieSearch;
use app\modules\products\models\ProductSearch;
use MediaEmbed\MediaEmbed;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class ProductMovieController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'create-ajax'],
                'rules' => [

                    [
                        'actions' => ['delete', 'create-ajax'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionDelete($id) {
        $model = ProductMovieSearch::findModel($id);
        $product_id = $model->product_id;
        $model->delete();

        $movieSearch = new ProductMovieSearch();
        $movieSearch->product_id = $product_id;

        return $this->renderPartial('_grid', [
                    'movieSearch' => $movieSearch,
        ]);

        //return 'sdfsdf';
        //Yii::$app->response->format = Response::FORMAT_RAW;
        //return $this->redirect(['/admin/product/update', 'id' => $product_id]);
    }

    public function actionCreateAjax($id) {

        $product = ProductSearch::findModel($id);
        $model = new ProductMovie();

        $model->product_id = $product->id;
        $model->user_id = Yii::$app->getUser()->id;

        if ($model->load(Yii::$app->request->post())) {

            $model->thumb = $model->getThumbUrl();
            $model->embed = $model->getEmbed();
            $model->videoid = $model->getVideoId();

            if ($model->save()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['status' => 'success'];
            }
        }
    }

    public function actionView($id) {

        $model = ProductMovieSearch::findModel($id);
        $em = new MediaEmbed();
        $info = $em->parseUrl($model->link);

        return $this->render('view', ['info' => $info]);
    }

    public function actionUpdate($id) {

        $model = ProductMovieSearch::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/product/update', 'id' => $model->product_id]);
        }

        return $this->render('update', ['model' => $model]);
    }

}
