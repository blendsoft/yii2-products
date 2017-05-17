<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<section id="content_wrapper">
    <header id="topbar" class="ph10">
        <?php echo $this->render('_menu'); ?>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">  
        <div class="chute chute-center">       
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs">Products</span>
                        </div>
                        <div class="panel-body pn">
                            <div class="table-responsive">                                                                                              
                                <?php
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        [
                                            'value' => function ($data) {
                                                return $data->getSmallCroppedTag();
                                            },
                                            'format' => 'raw',
                                            'options' => ['class' => 'w75']
                                        ],
                                        [
                                            'attribute' => 'user_id',
                                            'value' => function ($data) {
                                                return $data->getUserNamesToViewTag();
                                            },
                                            'format' => 'raw',
                                        ],
                                        'name',
                                        'price',
                                        'published',
                                        'promoted',
                                          [
                                            'attribute' => 'created',
                                            'value' => function ($data) {
                                                return Yii::$app->formatter->asDate($data->created);
                                            },
                                            'format' => 'raw',
                                        ],          
                                        [
                                            'class' => ActionColumn::className(),
                                        ],
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                       
        </div>     
    </section>
    <!-- -------------- /Content -------------- -->
</section>
