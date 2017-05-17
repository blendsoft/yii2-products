<?php

namespace app\modules\products\modules\admin\controllers;

use app\modules\products\models\Product;
use app\modules\products\models\ProductAttribute;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;



/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductAttributeController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['admin', 'create', 'update', 'delete', 'index'],
                'rules' => [
                    [
                        'actions' => ['admin', 'create', 'update', 'delete', 'index'],
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex() {
        
        $searchModel = new ProductAttribute();
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

        $model = new ProductAttribute();      
        $model->product_type_id = Product::TYPE_PRODUCT;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Zapisano.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {

            //var_dump($model->errors);

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
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Zapisano.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {

            return $this->render('update', [
                        'model' => $model,                       
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

   
    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductAttribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
