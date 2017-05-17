<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="sources" class="tab-pane"> 
    <div class="row">
        <div class="col-md-4">
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
                </div>
            </div>
        </div>
        <div class="col-md-8">           
            <div class="panel pln">
                <div class="panel-heading">
                    <span class="panel-title">Sources</span>
                </div>
                <div class="panel-body pln">
                    <?php
                    echo FileInput::widget([
                        'model' => $model,
                        'attribute' => 'sources',
                        'options' => [
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowedFileExtensions' => ['rar', 'zip'],
                            'uploadUrl' => Url::to(['/admin/product/upload-source', 'id' => $model->id]),
                            'initialPreview' => $model->getSourcesTagArray(),
                            'initialPreviewConfig' => $model->getSourcesPreviewConf(),
                            'uploadExtraData' => [
                                'id' => $model->id,
                            ],
                            'maxFileCount' => 1
                        ]
                    ]);
                    ?>
                </div>
            </div>


        </div>
    </div>

</div>