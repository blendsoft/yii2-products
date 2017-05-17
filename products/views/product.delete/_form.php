<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\uploader\UploaderWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\products\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'media_type')->textInput() ?>

    <?= $form->field($model, 'tmpImages')->textInput([]) ?>

    <?php
    echo UploaderWidget::widget([]);
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
