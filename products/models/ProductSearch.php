<?php

namespace app\modules\products\models;

use app\modules\products\models\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * ProductSearch represents the model behind the search form about `app\modules\products\models\Product`.
 */
class ProductSearch extends Product {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'media_type_id', 'created', 'updated'], 'integer'],
            [['name'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function searchUserProduct() {

        $query = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere([
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }

    public function searchPublishedProduct() {

        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (empty($this->tmpCategories) === false) {
            $query->withCategory($this->tmpCategories);
        }

        if (empty($this->tmpSoftwares) === false) {
            $query->withSoftware($this->tmpSoftwares);
        }

        if (empty($this->tmpFormats) === false) {
            $query->withFormat($this->tmpFormats);
        }

        if (empty($this->tmpEngines) === false) {
            $query->withEngine($this->tmpEngines);
        }

        if (empty($this->boughtUser_id) === false) {
            $query->boughtByUser($this->boughtUser_id);
        }

        if (empty($this->salesUser_id) === false) {
            $query->salesByUser($this->salesUser_id);
        }

        if (empty($this->keyword) === false) {
            $query->andWhere(['like', 'name', $this->keyword]);
        }

        if (empty($this->published) === false) {
            $query->andWhere(['published', $this->published]);
        }


        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'published' => Product::STATUS_PUBLISHED,
        ]);

        return $dataProvider;
    }

    public function searchProduct() {

        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (empty($this->tmpCategories) === false) {
            $query->withCategory($this->tmpCategories);
        }

        if (empty($this->tmpSoftwares) === false) {
            $query->withSoftware($this->tmpSoftwares);
        }

        if (empty($this->tmpFormats) === false) {
            $query->withFormat($this->tmpFormats);
        }

        if (empty($this->boughtUser_id) === false) {
            $query->boughtByUser($this->boughtUser_id);
        }

        if (empty($this->salesUser_id) === false) {
            $query->salesByUser($this->salesUser_id);
        }

        if (empty($this->keyword) === false) {
            $query->andWhere(['like', 'name', $this->keyword]);
        }

        if (empty($this->published) === false) {
            $query->andWhere(['published', $this->published]);
        }


        $query->andFilterWhere(['or',
            ['user_id' => $this->user_id],
            ['adder_id' => $this->adder_id],
        ]);

        return $dataProvider;
    }

    public function search($params) {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created' => SORT_DESC,
                ]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'media_type_id' => $this->media_type_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'published' => $this->published
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function searchRandom($count = null) {
        $query = Product::find()->random();

        if ($count != null) {
            $query = $query->limit($count);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        return $dataProvider;
    }

    public static function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
