<?php
use kartik\select2\Select2;
?>
<?php
echo $form->field($node, 'product_attributes')->widget(Select2::classname(), [
    'data' => \app\modules\products\models\ProductAttribute::find()->select(['name'])->indexBy('id')->column(),
    'options' => ['placeholder' => Yii::t('app', 'Select an attributes')],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple' => true,
    ],
]);
?>