<?php
use yii\helpers\Html;
?>

<div class="topbar-left">
    <?php echo $this->render('@admin/views/layouts/_top_menu');?>
</div>
<div class="topbar-right hidden-xs hidden-sm mt5 mr35">

    <?php
    echo Html::a('<span class="fa fa-plus pr5"></span><span class="fa fa-file-o pr5"></span>', '/admin/product/create', [
        'class' => 'btn btn-primary btn-sm ml10',
        'title' => 'Dodaj'
    ]);

    echo Html::a('<span class="fa fa-list"></span>', '/user-allegro-profile/index', [
        'class' => 'btn btn-primary btn-sm ml10',
        'title' => 'Lista'
    ]);
    ?>                     
    <?php
    if (isset($model) && $model->isPublished() === false) {
        echo Html::a('<span class="fa fa-share"></span>', ['/admin/product/publish', 'id' => $model->id], [
            'class' => 'btn btn-primary btn-sm ml10',
            'data' => ['confirm' => Yii::t('app', 'Are you sure ?')],
            'title' => Yii::t('app', 'Publish new product'),
        ]);
    }
    ?>   


</div>