<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div id="attributes" class="tab-pane">   
    <div class="row">                           
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo Yii::t('app', 'Product attributes') ?></span>
                </div>
                <div class="panel-body">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'attributes-form',
                                //'enableClientValidation' => false,
                                //'enableAjaxValidation' => true,
                                'options' => [
                                    'class' => 'form',
                                //    'enctype' => 'multipart/form-data',
                                ],
                                'fieldConfig' => [
                                    'labelOptions' => ['class' => 'col-lg-3 control-label'],
                                    'template' => '<div class="col-lg-12">{label}</div><div class="col-lg-12">{input}{error}</div>',
                                    'inputOptions' => ['class' => 'form-control'],
                                //   'options' => ['tag' => 'label', 'class' => 'field prepend-icon']
                                ],
                    ]);
                    ?>
                    
                    <?php foreach ($productAttrs as $pattr):?>
                        <?php echo $pattr->getFormField($form, $pattr, $model);?>
                    <?php endforeach;?>
                    

                    <div class="panel-footer text-right">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
