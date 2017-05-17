<?php

namespace app\modules\products\modules\admin\controllers;

use app\modules\products\models\Product;
use app\modules\products\models\ProductAttribute;
use app\modules\products\models\ProductCategory;
use app\modules\products\models\ProductCompat;
use app\modules\products\models\ProductFileFormat;
use app\modules\products\models\ProductGameEngine;
use app\modules\products\models\ProductGameEngines;
use app\modules\products\models\ProductGameEnginesSearch;
use app\modules\products\models\ProductImage;
use app\modules\products\models\ProductMovie;
use app\modules\products\models\ProductMovieSearch;
use app\modules\products\models\ProductSearch;
use Intervention\Image\ImageManager;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['admin', 'create', 'update', 'delete', 'index', 'view', 'upload', 'upload-main', 'image', 'for-publish'],
                'rules' => [
                    [
                        'actions' => ['admin', 'create', 'update', 'delete', 'index', 'view', 'upload', 'upload-main', 'image', 'publish', 'for-publish'],
                        'allow' => true,
                        'roles' => ['admin'],
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

    /**
     * Confirm a new Product model.
     * @return mixed
     */
    public function actionPublish($id) {
        $model = ProductSearch::findModel($id);
        $model->checkIsOwner();

        $model->published = Product::STATUS_PUBLISHED;
        $model->save(false);
        return $this->redirect(['/admin/product/update', 'id' => $model->id]);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionAdmin() {

        $searchModel = new ProductSearch();
        $searchModel->user_id = Yii::$app->getUser()->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionForPublish() {
        $searchModel = new ProductSearch();
        $searchModel->published = Product::STATUS_FOR_PUBLISHED;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new Product();
        $model->user_id = Yii::$app->getUser()->id;
        $model->media_type_id = Product::TYPE_MODEL_3D;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->updateProductAttributes();

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {



        $model = $this->findModel($id);
        $movie = new ProductMovie();
        $movieSearch = new ProductMovieSearch();
        $movieSearch->product_id = $model->id;
        $engine = new ProductGameEngines;
        $engineSearch = new ProductGameEnginesSearch();
        $engineSearch->product_id = $model->id;

        $productAttrs = ProductAttribute::findAll($model->getProductAttributesByCategory());

        //var_dump($productAttrs);

        /**
         * ładujemy atrybuty wczesniej zeby przeszla walidacja.
         */
        $model->loadProductAttributes();


        $post = Yii::$app->request->post('ProductAttributes');
        if (is_array($post)) {
            $model->saveProductAttributes($post);
            Yii::$app->session->setFlash('success', Yii::t('app', 'Zapisano atrybuty.'));
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (empty($model->tmpCategories) === false) {
                $catArray = $model->createCategoryArray();
                $cats = ProductCategory::findAll($catArray);
                $model->unlinkAll('categories', true);
                foreach ($cats as $cat) {
                    echo $model->link('categories', $cat);
                }
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['status' => 'success'];
            }
            if (empty($model->tmpSoftwares) === false) {
                $softs = ProductCompat::findAll($model->tmpSoftwares);
                $model->unlinkAll('softwares', true);
                foreach ($softs as $soft) {
                    echo $model->link('softwares', $soft);
                }
            }
            if (empty($model->tmpFormats) === false) {
                $formats = ProductFileFormat::findAll($model->tmpFormats);
                $model->unlinkAll('formats', true);
                foreach ($formats as $format) {
                    echo $model->link('formats', $format);
                }
            }
            if (empty($model->tmpEngines) === false) {
                $engines = ProductGameEngine::findAll($model->tmpEngines);
                $model->unlinkAll('engines', true);
                foreach ($engines as $engine) {
                    echo $model->link('engines', $engine);
                }
            }


            $model->updateProductAttributes();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Data saved.'));

            return $this->redirect(['update', 'id' => $model->id]);
        } else {

            //var_dump($model->errors);
            //$model->tmpCategories = $model->getCategories()->asArray()->all();            
            $model->tmpCategories = ProductCategory::getIdsString($model->getCategories());
            $model->tmpSoftwares = $model->getSoftwares()->indexBy('id')->column();
            $model->tmpFormats = $model->getFormats()->indexBy('id')->column();
            $model->tmpEngines = $model->getEngines()->indexBy('id')->column();

            //exit(0);
            return $this->render('update', [
                        'engine' => $engine,
                        'model' => $model,
                        'movie' => $movie,
                        'movieSearch' => $movieSearch,
                        'engineSearch' => $engineSearch,
                        'productAttrs' => $productAttrs,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUpload($id) {

        $model = $this->findModel($id);

        $gImage = new ProductImage();
        $gImage->file = UploadedFile::getInstance($model, 'tmpImages');
        $gImage->product_id = $model->id;
        $gImage->save(false);
        $gImage->upload();
        $gImage->save(false);

        echo Json::encode([]);
    }

    public function actionUploadMain($id) {
        $model = $this->findModel($id);
        $model->image = UploadedFile::getInstance($model, 'mainImage');
        $model->uploadMain();
        $model->save(false);
        echo Json::encode([]);
    }

    public function actionUploadSource($id) {

        $model = $this->findModel($id);
        $model->sources = UploadedFile::getInstance($model, 'sources');
        $model->uploadSource();
        $model->save(false);

        echo Json::encode([]);
    }

    public function actionImage() {

        $slug = Inflector::slug(Product::className(), '_');
        $file = Yii::getAlias('@webroot/uploads/' . $slug . '/org_11.png');
        //var_dump($file);

        $manager = new ImageManager(['driver' => 'gd', 'cache' => ['path' => 'cache/']]);
        //$img = $manager->make($file)->resize(300, 200)->greyscale();
//        $img = $manager->cache(function($image) {
//            $image->make('/home/darek/openshift/webstock/web/uploads/appmodulesproductsmodelsproduct/org_11.png')->resize(300, 200)->greyscale();
//        }, 10, true);



        $img = $manager->cache(function($image) use ($file) {
            $image->make($file)->resize(300, 200);
        }, 10, true);


        //var_dump($manager->config);

        Yii::$app->response->format = Response::FORMAT_RAW;
        echo $img->response('jpg', 90);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
