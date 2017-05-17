<?php

namespace app\modules\products\models;

/**
 * Description of ProductMovieSearch
 *
 * @author darek
 */

use yii\data\ActiveDataProvider;
class ProductMovieSearch extends ProductMovie {

    public function search($params) {
        
        $query = ProductMovie::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);        
        $this->load($params);
        $query->andFilterWhere(['product_id' => $this->product_id]);
        
        return $dataProvider;
    }
    
      public static function findModel($id) {
        if (($model = ProductMovie::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
