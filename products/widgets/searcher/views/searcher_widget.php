<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
            'id' => 'searcher-form',
            'options' => ['class' => 'navbar-form navbar-left search-form square']
        ])
?> 
<div class="input-group add-on">
    <?php echo $form->field($model, 'keyword', ['template' => '{input}'])->textInput(['class' => 'form-control', 'placeholder' => Yii::t('app', 'Search...')]); ?>
    <div class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
    </div>
</div>

<?php ActiveForm::end() ?>