<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
?>

    <?php
    Pjax::begin(['id' => 'pjax-product-list', 'timeout' => false, 'enablePushState' => false, 'enableReplaceState' => true, 'clientOptions' => []]);
    echo ListView::widget([
        'id' => 'product-list',
        'summary' => false,
        'dataProvider' => $search->searchProduct(),
        'itemView' => '_product',
        'options' => ['class' => 'row'],
        'itemOptions' => ['class' => 'col-md-3']
        
    ]);
    Pjax::end();
    ?>
   