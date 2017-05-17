<?php

use app\modules\products\models\ProductCategory;
use kartik\tree\Module;
use kartik\tree\TreeView;
use yii\helpers\Url;
?>

<!-- -------------- Main Wrapper -------------- -->
<section id="content_wrapper">

    <header id="topbar" class="ph10">
        <?php echo $this->render('_menu'); ?>
    </header>     
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">
            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs">Kategorie produktów</span>
                        </div>
                        <div class="panel-body pn">
                            <?php
                            echo TreeView::widget([
                                // single query fetch to render the tree
                                // use the Product model you have in the previous step
                                'query' => ProductCategory::find()->addOrderBy('root, lft'),
                                'headingOptions' => ['label' => 'Kategorie'],
                                'fontAwesome' => false, // optional
                                'isAdmin' => true, // optional (toggle to enable admin mode)
                                'displayValue' => 1, // initial display value
                                'softDelete' => true, // defaults to true
                                'cacheSettings' => [
                                    'enableCache' => true   // defaults to true
                                ],
                                'iconEditSettings' => ['show' => 'list',],
                                'nodeAddlViews' => [
                                    Module::VIEW_PART_2 => '@app/modules/products/modules/admin/views/product-category/_tree_part_2'
                                ],
                                'nodeActions' => [
                                    Module::NODE_SAVE => Url::to(['/products/admin/product-node/save'])
                                ]
                            ]);
                            ?>

                        </div>
                    </div>
                </div>
            </div>




        </div>
        <!-- -------------- /Column Center -------------- -->

    </section>
    <!-- -------------- /Content -------------- -->

</section>
