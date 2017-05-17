<?php

namespace app\modules\products\controllers;

use Apfelbox\FileDownload\FileDownload;
use app\components\behaviors\PermissionsBehavior;
use app\modules\products\models\Product;
use app\modules\products\models\ProductCategory;
use app\modules\products\models\ProductCompat;
use app\modules\products\models\ProductFileFormat;
use app\modules\products\models\ProductGameEngines;
use app\modules\products\models\ProductGameEnginesSearch;
use app\modules\products\models\ProductImage;
use app\modules\products\models\ProductMovie;
use app\modules\products\models\ProductMovieSearch;
use app\modules\products\models\ProductSearch;
use app\modules\users\models\UserSearch;
use Intervention\Image\ImageManager;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\View;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete-image', 'my', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['delete-image', 'delete-source', 'my', 'create', 'update', 'publish', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'permissions' => [
                'class' => PermissionsBehavior::className()
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
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->checkIsOwnerOrAdder();

        $model->delete();
        return $this->redirect(['/products/product/my']);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionMy() {

        $this->layout = '@app/themes/3d/layouts/_profile';

        $searchModel = new ProductSearch();

        $searchModel->user_id = Yii::$app->getUser()->id;
        $searchModel->adder_id = Yii::$app->getUser()->id;

        $dataProvider = $searchModel->searchProduct();

        return $this->render('my', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * @return mixed
     */
    public function actionCreate() {

        $this->layout = '@app/themes/3d/layouts/_profile';


        $auth = Yii::$app->authManager;
        $user = $auth->getRole('user');
        $staff = $auth->getRole('staff');
        //$authorRole = $auth->getRoles();
        //var_dump($authorRole);
        //$auth->assign($authorRole, 14);
        //$auth->addChild($user, $staff);
        //var_dump(Yii::$app->user->id);
        //var_dump($auth->checkAccess(Yii::$app->user->id, 'user'));
        //var_dump($auth->checkAccess(Yii::$app->user->id, 'staff'));
        //var_dump(Yii::$app->user->can('user'));
        //var_dump(Yii::$app->user->can('staff'));
        //exit(0);

        $model = new Product();

        $user = UserSearch::findModel(Yii::$app->user->id);

        if ($user->user_id != null) {
            $model->user_id = $user->user_id;
            $model->adder_id = Yii::$app->getUser()->id;
        } else {
            $model->user_id = Yii::$app->getUser()->id;
        }
        $model->media_type_id = Product::TYPE_MODEL_3D;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->updateProductAttributes();

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            //var_dump($model->errors);
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Confirm a new Product model.
     * @return mixed
     */
    public function actionPublish($id) {

        $this->layout = '@app/themes/3d/layouts/main_profile';
        $model = ProductSearch::findModel($id);
        $model->checkIsOwner();

        $model->published = 1;
        $model->save(false);
        return $this->redirect(['/products/product/update', 'id' => $model->id]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $this->layout = '@app/themes/3d/layouts/_profile';

        $model = $this->findModel($id);

        $model->checkIsOwnerOrAdder();
        $movie = new ProductMovie();
        $movieSearch = new ProductMovieSearch();
        $movieSearch->product_id = $model->id;

        $engine = new ProductGameEngines;
        $engineSearch = new ProductGameEnginesSearch();
        $engineSearch->product_id = $model->id;


        /**
         * ładujemy atrybuty wczesniej zeby przeszla walidacja.
         */
        $model->loadProductAttributes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (empty($model->tmpCategories) === false) {
                $catArray = $model->createCategoryArray();
                $cats = ProductCategory::findAll($catArray);
                $model->unlinkAll('categories', true);
                foreach ($cats as $cat) {
                    $model->link('categories', $cat);
                }
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['status' => 'success'];
            }

            if (empty($model->tmpSoftwares) === false || empty($model->tmpFormats) === false) {
                if (empty($model->tmpSoftwares) === false) {
                    $softs = ProductCompat::findAll($model->tmpSoftwares);
                    $model->unlinkAll('softwares', true);
                    foreach ($softs as $soft) {
                        $model->link('softwares', $soft);
                    }
                }
                if (empty($model->tmpFormats) === false) {
                    $formats = ProductFileFormat::findAll($model->tmpFormats);
                    $model->unlinkAll('formats', true);
                    foreach ($formats as $format) {
                        $model->link('formats', $format);
                    }
                }
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['status' => 'success'];
            }

            $model->updateProductAttributes();

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success'];
            //return $this->redirect(['update', 'id' => $model->id]);
        } else {

            //var_dump($model->errors);
            //$model->tmpCategories = $model->getCategories()->asArray()->all();            
            $model->tmpCategories = ProductCategory::getIdsString($model->getCategories());
            $model->tmpSoftwares = $model->getSoftwares()->indexBy('id')->column();
            $model->tmpFormats = $model->getFormats()->indexBy('id')->column();

            //exit(0);
            return $this->render('update', [
                        'model' => $model,
                        'movie' => $movie,
                        'engine' => $engine,
                        'movieSearch' => $movieSearch,
                        'engineSearch' => $engineSearch,
            ]);
        }
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

//        var_dump($model->sources);
//        exit(0);

        $model->uploadSource();
        $model->save(false);

        echo Json::encode([]);
    }

    public function actionDownloadSource($id) {
        $model = $this->findModel($id);
        $file = $model->getSourceFilePath();
        if ($model->isBought() && empty($model->sources) === false && file_exists($file)) {
            $fileDownload = FileDownload::createFromFilePath($file);
            $fileDownload->sendDownload($model->sources);
        } else {
            $this->redirect(['/products/product/index']);
        }
    }

    public function actionPromoted() {




        return $this->render('promoted', []);
    }

    /**
     * @param null $category_id
     * @param null $software
     * @param null $format
     * @param null $keyword
     * @param string $view
     * @return string
     */
    public function actionIndex($category_id = null, $software = null, $format = null, $engine = null, $keyword = null, $view = 'box') {

        $options = [
            'boxUrl' => Url::to(['/products/product/index', 'category_id' => $category_id, 'view' => 'box']),
            'rowUrl' => Url::to(['/products/product/index', 'category_id' => $category_id, 'view' => 'row']), //  'clearCart' => true,
                // 'filters' => ['software' => null, 'format' => null],
        ];

        if (null != $category_id) {
            $options['filters']['category_id'] = $category_id;
        }

        Yii::$app->view->registerJs("var options = " . json_encode($options) . ";", View::POS_END, 'my-options');

        $search = new ProductSearch();
        $search->tmpCategories = $category_id;
        $search->tmpSoftwares = $software;
        $search->tmpFormats = $format;
        $search->tmpEngines = $engine;
        $search->keyword = $keyword;

        //var_dump(Yii::$app->request->getQueryParams());

        $cols = $view == 'box' ? 3 : 12;

        return $this->render('index', [
                    'search' => $search,
                    'view' => $view,
                    'cols' => $cols,
                    'showPromo' => empty(Yii::$app->request->getQueryParams()) ? true : false,
        ]);
    }

    public function actionImage($id, $width = null, $height = null) {

        $slug = Inflector::slug(Product::className(), '_');
        $file = Yii::getAlias('@webroot/uploads/' . $slug . '/org_' . $id . '.jpg');
        if (file_exists($file)) {
            $manager = new ImageManager(['driver' => 'gd', 'cache' => ['path' => 'cache']]);
            $img = $manager->cache(function ($image) use ($file, $width, $height) {
                $image->make($file);
                if (null !== $width or null !== $height) {
                    $image->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
            }, 525600, true);
        } else {
            $manager = new ImageManager(['driver' => 'gd']);
            $img = $manager->make(Yii::getAlias('@webroot/img/user-icon.png'));
        }

        Yii::$app->response->format = Response::FORMAT_RAW;

        header('Content-Type: image/jpg');
        header("Last-Modified: Fri, 13 May 2016 13:16:19 GMT");
        echo $img->encode('jpg', 90);
    }

    public function actionImageCrop($id, $width = null, $height = null) {

        $slug = Inflector::slug(Product::className(), '_');
        $file = Yii::getAlias('@webroot/uploads/' . $slug . '/org_' . $id . '.jpg');
        if (file_exists($file)) {
            $manager = new ImageManager(['driver' => 'gd', 'cache' => ['path' => 'cache']]);
            $img = $manager->cache(function ($image) use ($file, $width, $height) {
                $image->make($file);
                if (null !== $width or null !== $height) {
                    $image->fit($width, $height);
                }
            }, 525600, true);
        } else {
            $manager = new ImageManager(['driver' => 'gd']);
            $img = $manager->make(Yii::getAlias('@webroot/img/user-icon.png'));
            $img->fit($width, $height);
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        header('Content-Type: image/jpg');
        header("Last-Modified: Fri, 13 May 2016 13:16:19 GMT");
        echo $img->encode('jpg', 90);
    }

    public function actionDeleteImage($id) {
        $model = $this->findModel($id);
        $model->image = null;
        $model->save(false);
        echo Json::encode([]);
    }

    public function actionDeleteSource($id) {
        $model = $this->findModel($id);
        $model->sources = null;
        $model->sources_files = null;
        $model->save(false);
        echo Json::encode([]);
    }

    public function actionView($id) {

        $model = $this->findModel($id);
        $model->loadProductAttributes();
        $images = $model->images;
        $movies = $model->movies;
        return $this->render('view', [
                    'model' => $model,
                    'images' => $images,
                    'movies' => $movies,
        ]);
    }

    public function actionGetJsonData($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = ProductSearch::findModel($id);

        if ($model->isBought() === true) {
            return [
                'status' => 'error',
                'message' => Yii::t('app', 'Bought')
            ];
        } elseif ($model->getIsOwner() === true) {
            return [
                'status' => 'error',
                'message' => Yii::t('app', 'Owner')
            ];
        } else {
            return [
                'status' => 'success',
                'id' => $model->id,
                'title' => $model->name,
                'url' => $model->getNameToView(),
                'thumb' => $model->getMiniCroppedTag(),
                'price' => $model->getPrice(),
            ];
        }
    }

}
