<?php

namespace app\modules\products\models;

/**
 * This is the ActiveQuery class for [[Product]].
 *
 * @see Product
 */
class ProductQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      $this->andWhere('[[status]]=1');
      return $this;
      } */

    public function withCategory($category_id) {
        $this->select('product.*')
                ->leftJoin('product_categories', '`product_categories`.`product_id` = `product`.`id`')
                ->andWhere(['product_categories.category_id' => $category_id]);

        return $this;
    }

    public function withSoftware($software_id) {
        $this->select('product.*')
                ->leftJoin('product_compats', '`product_compats`.`product_id` = `product`.`id`')
                ->andWhere(['product_compats.product_compat_id' => $software_id]);

        return $this;
    }

    public function withFormat($format_id) {
        $this->select('product.*')
                ->leftJoin('product_file_formats', '`product_file_formats`.`product_id` = `product`.`id`')
                ->andWhere(['product_file_formats.product_format_id' => $format_id]);

        return $this;
    }

    public function withEngine($engine_id) {
        $this->select('product.*')
                ->leftJoin('product_game_engines', '`product_game_engines`.`product_id` = `product`.`id`')
                ->andWhere(['product_game_engines.product_game_engine_id' => $engine_id]);

        return $this;
    }

    public function attributeName($name) {
        $this->select('product.*')
                ->leftJoin('product_categories', '`product_categories`.`product_id` = `product`.`id`')
                ->andWhere(['product_categories.category_id' => $category_id]);

        return $this;
    }

    public function boughtByUser($user_id) {
        $this->select('product.*')
                ->leftJoin('shop_buys', '`shop_buys`.`product_id` = `product`.`id`')
                ->andWhere(['shop_buys.user_id' => $user_id]);

        return $this;
    }

    public function promoted() {
        $this->select('product.*')
                ->andWhere(['promoted' => 1]);
        return $this;
    }

    public function random() {
        $this->select('product.*')
                ->orderBy("rand()");

        return $this;
    }

    public function salesByUser($user_id) {
        $this
                ->select('product.*')
                //->distinct(false)
                ->joinWith('buys', false)
                //->leftJoin('shop_buys', '`shop_buys`.`product_id` = `product`.`id`', false)
                ->andWhere(['product.user_id' => $user_id])
                ->orderBy('shop_buys.created asc');



        return $this;
    }

    public function pk($id) {
        $this->andWhere(['id' => $id]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return Product[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Product|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
