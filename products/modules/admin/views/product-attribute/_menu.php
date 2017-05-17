<?php

use yii\widgets\Menu;
use yii\helpers\Html;
?>

<div class="topbar-left">
    <?php
    echo Menu::widget([
        'options' => ['class' => 'nav nav-list nav-list-topbar pull-left'],
        'items' => [
            ['label' => 'Produkty', 'url' => ['/products/admin/product/index']],
            ['label' => 'Kategorie', 'url' => ['/products/admin/product-category/index']], 
            ['label' => 'Atrybuty', 'url' => ['/products/admin/product-attribute/index']],
        ],
    ]);
    ?>
</div>
<div class="topbar-right hidden-xs hidden-sm mt5 mr35">
    

    <?php
    echo Html::a('<span class="fa fa-plus pr5"></span><span class="fa fa-file-o pr5"></span>', '/products/admin/product-attribute/create', [
        'class' => 'btn btn-primary btn-sm ml10',
        'title' => 'Dodaj'
    ]);

    echo Html::a('<span class="fa fa-list"></span>', '/products/admin/product-attribute/index', [
        'class' => 'btn btn-primary btn-sm ml10',
        'title' => 'Lista'
    ]);
    ?>                     
</div>