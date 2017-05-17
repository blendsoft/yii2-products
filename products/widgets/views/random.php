<?php
use yii\widgets\ListView;
?>
<div  class="row main-products-list">
    <?php
    echo ListView::widget([
        'id' => 'product-list',
        'itemOptions' => ['class' => 'col-md-4'],
        'summary' => false,
        'dataProvider' => $search->searchRandom($count),
        'itemView' => '_product_box',
        'viewParams' => [
        ],
    ]);
    ?>
</div>