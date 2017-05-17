<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<!-- -------------- Main Wrapper -------------- -->
<section id="content_wrapper">
    <!-- -------------- Topbar -------------- -->
    <header id="topbar" class="ph10">
        <?php echo $this->render('_menu'); ?>
    </header>
    <!-- -------------- /Topbar -------------- -->

    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"><?php echo Yii::t('app', 'Attrybuty'); ?></span>
                        </div>
                        <div class="panel-body pn">


                            <div class="table-responsive">    
                                <?php
                                Pjax::begin(['id' => 'pjax-product-list', 'timeout' => false, 'enablePushState' => false, 'enableReplaceState' => true, 'clientOptions' => []]);
                                echo GridView::widget([
                                    'id' => 'attributes-index-grid',
                                    'dataProvider' => $dataProvider,
                                    'formatter' => [
                                        'class' => 'yii\i18n\Formatter',
                                        'nullDisplay' => '&nbsp;'
                                    ],
                                    'columns' => [
                                        'name',
                                        'fieldType',
                                        [
                                            'class' => ActionColumn::className(),
                                            'template' => "{update} {delete}"
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
        </div>
        <!-- -------------- /Column Center -------------- -->
    </section>
    <!-- -------------- /Content -------------- -->
</section>
