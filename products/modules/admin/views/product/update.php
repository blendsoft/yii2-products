<?php

use app\modules\products\models\Product;
use app\modules\products\models\ProductCategory;
use app\modules\products\models\ProductCompat;
use app\modules\products\models\ProductFileFormat;
use app\modules\products\models\ProductGameEngine;
use app\modules\products\widgets\StatusBox;
use app\widgets\myckeditor\MyCKEditor;
use kartik\file\FileInput;
use kartik\tree\TreeViewInput;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>
<section id="content_wrapper">
    <header id="topbar" class="ph10">
        <?php echo $this->render('_menu', ['model' => $model]); ?>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">

                <?php
                echo StatusBox::widget(['model' => $model]);
                ?>

                <ul class="nav nav-tabs mb20 pull-left">
                    <li class="active">
                        <a href="#product" data-toggle="tab" aria-expanded="true">Product specification</a>
                    </li>
                    <li class="">
                        <a href="#attributes" data-toggle="tab" aria-expanded="true">Attributes</a>
                    </li>
                    <li class="">
                        <a href="#description" data-toggle="tab" aria-expanded="false">Description</a>
                    </li>
                    <li class="">
                        <a href="#category" data-toggle="tab" aria-expanded="false">Categories</a>
                    </li>
                    <li class="">
                        <a href="#software" data-toggle="tab" aria-expanded="false">Software</a>
                    </li> 
                    </li>
                    <li class="">
                        <a href="#game-engines" data-toggle="tab" aria-expanded="false">Game engines</a>
                    </li>
                    <li class="">
                        <a href="#movies" data-toggle="tab" aria-expanded="false">Movies</a>             
                    <li class="">
                        <a href="#tab17_3" data-toggle="tab" aria-expanded="false">Images</a>
                    </li>
                    <li class="">
                        <a href="#sources" data-toggle="tab" aria-expanded="false">Sources</a>
                    </li>

                </ul>
                <div class="clearfix"></div>
                <div class="tab-content br-n pn">
                    <div id="product" class="tab-pane active">
                        <div class="row">                            
                            <div class="col-md-12">

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
                                                    'template' => '<label class="checkbox">{label}{input}{error}</label>',
                                                    //  'options' => ['class' => ''],
                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('promoted')],
                                                ])
                                                ->label($model->getAttributeLabel('promoted'))
                                                ->checkbox(['data-toggle' => 'checkbox'], false)
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
                                                    'template' => '<label class="checkbox">{input}{label}{error}</label>',
                                                    //  'options' => ['class' => ''],
                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_textures')],
                                                ])
                                                ->label($model->getAttributeLabel('pattributes_textures'))
                                                ->checkbox([], false);
                                        ?>                   

                                        <?=
                                                $form
                                                ->field($model, 'pattributes_pbl_textures', [
                                                    'template' => '<label class="checkbox">{input}{label}{error}</label>',
                                                    //  'options' => ['class' => ''],
                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_pbl_textures')],
                                                ])
                                                ->label($model->getAttributeLabel('pattributes_pbl_textures'))
                                                ->checkbox([], false);
                                        ?>      


                                        <?=
                                                $form
                                                ->field($model, 'pattributes_materials', [
                                                    'template' => '<label class="checkbox">{input}{label}{error}</label>',
                                                    //  'options' => ['class' => ''],
                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_materials')],
                                                ])
                                                ->label($model->getAttributeLabel('pattributes_materials'))
                                                ->checkbox([], false);
                                        ?>  

                                        <?=
                                                $form
                                                ->field($model, 'pattributes_rigged', [
                                                    'template' => '<label class="checkbox">{input}{label}{error}</label>',
                                                    //  'options' => ['class' => ''],
                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_rigged')],
                                                ])
                                                ->label($model->getAttributeLabel('pattributes_rigged'))
                                                ->checkbox([], false);
                                        ?>  

                                        <?=
                                                $form
                                                ->field($model, 'pattributes_animated', [
                                                    'template' => '<label class="checkbox">{input}{label}{error}</label>',
                                                    //  'options' => ['class' => ''],
                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_animated')],
                                                ])
                                                ->label($model->getAttributeLabel('pattributes_animated'))
                                                ->checkbox([], false);
                                        ?>  

                                        <?=
                                                $form
                                                ->field($model, 'pattributes_uv_mapped', [
                                                    'template' => '<label class="checkbox">{input}{label}{error}</label>',
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
                                                    'template' => '<label class="checkbox">{input}{label}{error}</label>',
                                                    //  'options' => ['class' => ''],
                                                    'inputOptions' => ['placeholder' => $model->getAttributeLabel('pattributes_game_ready')],
                                                ])
                                                ->label($model->getAttributeLabel('pattributes_game_ready'))
                                                ->checkbox([], false);
                                        ?>      


                                        <div class="panel-footer text-right">
                                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                                        </div>

                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php echo $this->render('_attributes', ['productAttrs' => $productAttrs, 'model' => $model]); ?>

                    <div id="description" class="tab-pane">   
                        <div class="row">                           
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <span class="panel-title"><?php echo Yii::t('app', 'Product description') ?></span>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        $form = ActiveForm::begin([
                                                    'id' => 'description-form',
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
                                        <?=
                                        $form->field($model, 'description')->widget(MyCKEditor::className(), [
                                            'options' => ['rows' => 6],
                                                //'preset' => 'basic'
                                        ])
                                        ?>


                                        <?=
                                        $form->field($model, 'changes')->widget(MyCKEditor::className(), [
                                            'options' => ['rows' => 6],
                                                //'preset' => 'basic'
                                        ])
                                        ?>
                                        <div class="panel-footer text-right">
                                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="category" class="tab-pane">                        
                        <div class="row">                          
                            <div class="col-md-12">
                                <?php
                                $form = ActiveForm::begin([
                                            'id' => 'category-form',
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
                                <?php
                                echo TreeViewInput::widget([
                                    'model' => $model,
                                    'attribute' => 'tmpCategories',
                                    'value' => 'true', // preselected values
                                    'query' => ProductCategory::find()->addOrderBy('root, lft'),
                                    'headingOptions' => ['label' => 'Categories'],
                                    'rootOptions' => ['label' => '<i class="fa fa-tree text-success"></i>'],
                                    'fontAwesome' => true,
                                    'asDropdown' => false,
                                    'multiple' => true,
                                    'options' => ['disabled' => false]
                                ]);
                                ?>



                                <div class="panel-footer text-right">
                                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>


                            </div>
                        </div>

                    </div>

                    <div id="software" class="tab-pane">                        
                        <div class="row">                         
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <span class="panel-title">Software</span>
                                    </div>
                                    <div class="panel-body">

                                        <?php
                                        $form = ActiveForm::begin([
                                                    'id' => 'software-form',
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
                                                ->field($model, 'tmpSoftwares', [
                                                    'inputOptions' => [],
                                                    'template' => '<div class="col-lg-12">{input}{error}</div>',
                                                ])
                                                ->label($model->getAttributeLabel('tmpSoftwares'))
                                                ->checkboxList(
                                                        ProductCompat::find()->select(['name', 'id'])->indexBy('id')->column(), []
                                        );
                                        ?>

                                        <?=
                                                $form
                                                ->field($model, 'tmpFormats', [
                                                    'inputOptions' => [],
                                                    'template' => '<div class="col-lg-12">{input}{error}</div>',
                                                ])
                                                ->label($model->getAttributeLabel('tmpFormats'))
                                                ->checkboxList(
                                                        ProductFileFormat::find()->select(['name', 'id'])->indexBy('id')->column(), []
                                        );
                                        ?>




                                        <div class="panel-footer text-right">
                                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                                        </div>

                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>


                    <div id="movies" class="tab-pane"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">

                                        </div>

                                        <div id="product-movie-modal" class="white-popup mfp-hide pn mn">
                                            <div class="panel mbn pn mn">      
                                                <div class="panel-body">
                                                    <?php
                                                    $form = ActiveForm::begin([
                                                                'id' => 'create-movie-form',
                                                                'action' => ['/admin/product-movie/create-ajax', 'id' => $model->id],
                                                                //'enableClientValidation' => true,
                                                                //'enableAjaxValidation' => true,
                                                                'options' => [
                                                                    'class' => 'form-inline',
                                                                //    'enctype' => 'multipart/form-data',
                                                                ],
                                                                'fieldConfig' => [
                                                                    'labelOptions' => ['class' => ''],
                                                                    'template' => '{label}{input}{error}',
                                                                    'inputOptions' => ['class' => 'form-control'],
                                                                    'errorOptions' => ['class' => 'hidden'],
                                                                //   'options' => ['tag' => 'label', 'class' => 'field prepend-icon']
                                                                ],
                                                    ]);
                                                    ?>
                                                    <?=
                                                    $form->field($movie, 'name', [
                                                        'inputOptions' => ['placeholder' => $movie->getAttributeLabel('name')],
                                                    ]);
                                                    ?>

                                                    <?=
                                                    $form->field($movie, 'link', [
                                                        'inputOptions' => ['placeholder' => $movie->getAttributeLabel('link')],
                                                    ]);
                                                    ?> 

                                                    <div class="panel-footer text-right">
                                                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                                                    </div>

                                                    <?php ActiveForm::end(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel pln">
                                    <div class="panel-heading">
                                        <span class="panel-title">Movies</span>
                                    </div>
                                    <div class="panel-body pln">
                                        <?php
                                        Pjax::begin([
                                            'id' => 'product-movies',
                                            'timeout' => false,
                                            'enablePushState' => false,
                                            'clientOptions' => [
                                            ]
                                        ]);
                                        echo GridView::widget([
                                            'id' => 'product-movie-grid',
                                            'dataProvider' => $movieSearch->search([]),
                                            'columns' => [
                                                [
                                                    'value' => function($data) {
                                                        return $data->getThumb();
                                                    },
                                                    'format' => 'raw',
                                                    'options' => ['class' => 'w75']
                                                ],
                                                'name',
                                                'link',
                                                [
                                                    'class' => ActionColumn::className(),
                                                    'urlCreator' => function($action, $model, $key, $index) {
                                                        return ['/admin/product-movie/' . $action, 'id' => $key];
                                                    }
                                                ],
                                            ],
                                        ]);
                                        Pjax::end();
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="game-engines" class="tab-pane"> 
                        <div class="row">                           
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                                            <?php
//                                                    echo Html::a('<span class="fa fa-plus pr5"></span><span class="fa fa-file-o pr5"></span>', '#product-movie-modal', [
//                                                        'class' => 'btn btn-primary btn-sm ml10 simple-ajax-popup',
//                                                        'title' => 'Dodaj'
//                                                    ]);
                                            ?>
                                        </div>

                                        <div id="product-engine-modal" class="white-popup pn mn mfp-hide">
                                            <div class="panel mbn pn mn">      
                                                <div class="panel-body">

                                                    <?php
                                                    $form = ActiveForm::begin([
                                                                'id' => 'create-engine-form',
                                                                'action' => ['/admin/product-game-engines/create-ajax', 'id' => $model->id],
                                                                //'enableClientValidation' => true,
                                                                'enableAjaxValidation' => true,
                                                                'options' => [
                                                                    'class' => 'form-inline',
                                                                //    'enctype' => 'multipart/form-data',
                                                                ],
                                                                'fieldConfig' => [
                                                                    'labelOptions' => ['class' => ''],
                                                                    'template' => '{label}{input}{error}',
                                                                    'inputOptions' => ['class' => 'form-control'],
                                                                    'errorOptions' => ['class' => 'hidden'],
                                                                //   'options' => ['tag' => 'label', 'class' => 'field prepend-icon']
                                                                ],
                                                    ]);
                                                    ?>

                                                    <?php //echo $form->errorSummary($engine);  ?>

                                                    <?=
                                                            $form
                                                            ->field($engine, 'product_game_engine_id', [
                                                                'inputOptions' => ['placeholder' => $engine->getAttributeLabel('product_game_engine_id')],
                                                            ])
                                                            ->label($engine->getAttributeLabel('product_game_engine_id'))
                                                            ->dropdownList(
                                                                    ProductGameEngine::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => Yii::t('app', 'Select')]
                                                    );
                                                    ?>

                                                    <?=
                                                    $form->field($engine, 'value_string', [
                                                        'options' => ['class' => 'form-group hidden'],
                                                        'inputOptions' => ['placeholder' => $engine->getAttributeLabel('value_string')],
                                                    ]);
                                                    ?>

                                                    <?=
                                                    $form->field($engine, 'version', [
                                                        'inputOptions' => ['placeholder' => $engine->getAttributeLabel('version')],
                                                    ]);
                                                    ?>




                                                    <div class="panel-footer text-right">
                                                        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-bordered btn-primary mb5', 'name' => 'save-button']) ?>
                                                    </div>

                                                    <?php ActiveForm::end(); ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="panel pln">
                                    <div class="panel-heading">
                                        <span class="panel-title">Engines</span>
                                    </div>
                                    <div class="panel-body pln">
                                        <?php
                                        Pjax::begin([
                                            'id' => 'product-engines',
                                            'timeout' => false,
                                            'enablePushState' => false,
                                            'clientOptions' => [
                                            ]
                                        ]);
                                        echo GridView::widget([
                                            'id' => 'product-engines-grid',
                                            'dataProvider' => $engineSearch->search([]),
                                            'columns' => [
                                                [
                                                    'label' => Yii::t('app', 'Name'),
                                                    'value' => function($data) {
                                                        return $data->getEngineName();
                                                    },
                                                //'format' => 'raw',
                                                //'options' => ['class' => 'w75']
                                                ],
                                                'version',
                                                [
                                                    'class' => ActionColumn::className(),
                                                    'template' => '{update} {delete}',
                                                    'urlCreator' => function($action, $model, $key, $index) {
                                                        return ['/admin/product-game-engines/' . $action, 'id' => $key];
                                                    }
                                                ],
                                            ],
                                        ]);
                                        Pjax::end();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div id="tab17_3" class="tab-pane">
                        <div class="row">
                          

                            <div class="col-md-12">
                                <div class="panel pln">
                                    <div class="panel-heading ">
                                        <span class="panel-title">Main photo</span> 
                                    </div>


                                    <div class="panel-body pn mn">
                                        <?php
                                        echo FileInput::widget([
                                            'model' => $model,
                                            'attribute' => 'mainImage',
                                            'options' => [
                                                'multiple' => false
                                            ],
                                            'pluginOptions' => [
                                                'allowedFileExtensions' => ['jpg', 'png'],
                                                'uploadUrl' => Url::to(['/admin/product/upload-main', 'id' => $model->id]),
                                                'initialPreview' => $model->getTagArray(),
                                                'initialPreviewConfig' => $model->getPreviewConf(),
                                                'uploadExtraData' => [
                                                    'id' => $model->id,
                                                ],
                                                'maxFileCount' => 1
                                            ]
                                        ]);
                                        ?>
                                    </div>   
                                </div>   


                                <div class="panel pln">     
                                    <div class="panel-heading">
                                        <span class="panel-title">Gallery</span>
                                    </div>


                                    <div class="panel-body pln">   
                                        <?php
                                        echo FileInput::widget([
                                            'model' => $model,
                                            'attribute' => 'tmpImages',
                                            'options' => [
                                                'multiple' => true
                                            ],
                                            'pluginOptions' => [
                                                'allowedFileExtensions' => ['jpg', 'png'],
                                                'uploadUrl' => Url::to(['/admin/product/upload', 'id' => $model->id]),
                                                'uploadExtraData' => [
                                                    'id' => $model->id,
                                                ],
                                                'initialPreview' => $model->getTagsArray(),
                                                'initialPreviewConfig' => $model->getPreviewsConf(),
                                                'overwriteInitial' => false,
                                                'maxFileCount' => 100
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>                                   
                            </div>
                        </div>
                    </div>
                    <?php echo $this->render('_sources', ['model' => $model]); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- -------------- /Content -------------- -->
</section>