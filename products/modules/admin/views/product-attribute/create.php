<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<section id="content_wrapper">
    <header id="topbar" class="ph10">
        <?php echo $this->render('_menu'); ?>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="animated fadeIn">             
        <div class="row">


            <div class="col-md-12">

                <!-- -------------- Validation States -------------- -->

                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo Yii::t('app', 'Atrybut') ?></span>
                    </div>
                    <div class="panel-body">



                        <?php
                        $form = ActiveForm::begin([
                                    'id' => 'create-form',
                                    //'enableClientValidation' => false,
                                    //'enableAjaxValidation' => true,
                                    'options' => [
                                        'class' => 'form-horizontal',
                                        'enctype' => 'multipart/form-data',
                                    ],
                                    'fieldConfig' => [
                                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                                        'template' => '{label}<div class="col-lg-8">{input}{error}</div>',
                                        'inputOptions' => ['class' => 'form-control'],
                                    //   'options' => ['tag' => 'label', 'class' => 'field prepend-icon']
                                    ],
                        ]);
                        ?>


                        <?=
                        $form->field($model, 'name', [
                            'inputOptions' => ['placeholder' => $model->getAttributeLabel('name')],
                        ]);
                        ?>


                        <div class="panel-footer text-right">
                            <?= Html::submitButton(Yii::t('app', 'Zapisz'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- -------------- /Content -------------- -->
</section>