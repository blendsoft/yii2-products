<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use app\modules\products\models\Product;
?>
<section id="content_wrapper">

    <header id="topbar" class="ph10">
        <?php echo $this->render('_menu'); ?>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="animated fadeIn">

        <div class="row">

            <div class="col-md-4">

                <!-- -------------- Standard Fields -------------- -->
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Info text</span>
                    </div>
                    <div class="panel-body">

                        <ul>
                            <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>
                            <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>
                            <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>
                            <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>
                        </ul>


                        <?php
//                        echo FileInput::widget([
//                            'name' => 'attachment_48[]',
//                            'options' => [
//                                'multiple' => true
//                            ],
//                            'pluginOptions' => [
//                                'uploadUrl' => Url::to(['/site/file-upload']),
//                                'uploadExtraData' => [
//                                    'album_id' => 20,
//                                    'cat_id' => 'Nature'
//                                ],
//                                'maxFileCount' => 10
//                            ]
//                        ]);
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <!-- -------------- Validation States -------------- -->

                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo Yii::t('app', 'Product Specifications') ?></span>
                    </div>
                    <div class="panel-body">



                        <?php
                        $form = ActiveForm::begin([
                                    'id' => 'create-form',
                                    //'enableClientValidation' => false,
                                    //'enableAjaxValidation' => true,
                                    'options' => [
                                        'class' => 'form-horizontal',
                                    //    'enctype' => 'multipart/form-data',
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
                                $form
                                ->field($model, 'promoted', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-promoted"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('promoted')],
                                ])
                                ->label($model->getAttributeLabel('promoted'))
                                ->checkbox([], false);
                        ?>         
                        <?=
                        $form->field($model, 'name', [
                            'inputOptions' => ['placeholder' => $model->getAttributeLabel('name')],
                        ]);
                        ?>

                        <?=
                        $form->field($model, 'price', [
                            'inputOptions' => ['placeholder' => $model->getAttributeLabel('price')],
                        ]);
                        ?>

                        <?=
                        $form->field($model, 'price_off', [
                            'inputOptions' => ['placeholder' => $model->getAttributeLabel('price_off')],
                        ]);
                        ?>

                        <?=
                        $form->field($model, 'version', [
                            'inputOptions' => ['placeholder' => $model->getAttributeLabel('version')],
                        ]);
                        ?>

                        <?php
//                                        echo
//                                                $form
//                                                ->field($model, 'pattributes_geometry', [
//                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_geometry')],
//                                                ])
//                                                ->label($model->getAttributeLabel('pattributes_geometry'))
//                                                ->dropdownList(
//                                                        Product::$unwrapped_uvs, ['prompt' => Yii::t('app', 'Select')]
//                                        );
                        ?>

                        <?php
                        echo $form->field($model, 'pattributes_polygons', [
                            'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_polygons')],
                        ])->label($model->getAttributeLabel('pattributes_polygons'));
                        ?>


                        <?php
//                                        echo $form->field($model, 'pattributes_vertices', [
//                                            'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_vertices')],
//                                        ])->label($model->getAttributeLabel('pattributes_vertices'));
                        ?>


                        <?=
                                $form
                                ->field($model, 'pattributes_textures', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-pattributes_textures"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_textures')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_textures'))
                                ->checkbox([], false);
                        ?>                   

                        <?=
                                $form
                                ->field($model, 'pattributes_pbl_textures', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-pattributes_pbl_textures"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_pbl_textures')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_pbl_textures'))
                                ->checkbox([], false);
                        ?>      


                        <?=
                                $form
                                ->field($model, 'pattributes_materials', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-pattributes_materials"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_materials')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_materials'))
                                ->checkbox([], false);
                        ?>  

                        <?=
                                $form
                                ->field($model, 'pattributes_rigged', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-pattributes_rigged"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_rigged')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_rigged'))
                                ->checkbox([], false);
                        ?>  

                        <?=
                                $form
                                ->field($model, 'pattributes_animated', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-pattributes_animated"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_animated')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_animated'))
                                ->checkbox([], false);
                        ?>  

                        <?=
                                $form
                                ->field($model, 'pattributes_uv_mapped', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-pattributes_uv_mapped"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_uv_mapped')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_uv_mapped'))
                                ->checkbox([], false);
                        ?>  

                        <?=
                                $form
                                ->field($model, 'pattributes_unwrapped_uvs', [
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_unwrapped-uvs')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_unwrapped_uvs'))
                                ->dropdownList(
                                        Product::$unwrapped_uvs, ['prompt' => 'Select']
                        );
                        ?>

                        <?=
                                $form
                                ->field($model, 'pattributes_game_ready', [
                                    'template' => '{label}<div class="col-lg-8 switch switch-info switch-inline">{input} <label for="product-pattributes_game_ready"></label>{error}</div>',
                                    //  'options' => ['class' => ''],
                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_game_ready')],
                                ])
                                ->label($model->getAttributeLabel('pattributes_game_ready'))
                                ->checkbox([], false);
                        ?>      


                        <div class="panel-footer text-right">
                            <?= Html::submitButton(Yii::t('app', 'Next >>'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>






            </div>
        </div>


    </section>
    <!-- -------------- /Content -------------- -->
</section>