<?php 

?>

<?php if ($model->published == 0): ?>
    <div class="alert alert-danger" role="alert"><?php echo Yii::t('app', 'Product not published'); ?></div> 
<?php elseif ($model->published == 1): ?>
    <div class="alert alert-info" role="alert"><?php echo Yii::t('app', 'Product is waiting for publish'); ?></div> 
<?php elseif ($model->published == 2): ?>
    <div class="alert alert-success" role="alert"><?php echo Yii::t('app', 'Product published'); ?></div> 
<?php endif; ?>

