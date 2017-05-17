<div class="row">
    <div class="col-md-12">         
        <div id="promoted-view" style="margin:0px auto;display:none;">                          
            <?php foreach ($models as $model): ?>
            <img alt="<?php echo $model->getName(); ?>" src="<?php echo $model->getCroppedPath(); ?>" data-image="<?php echo $model->getOrgThumbPath() ?>" data-description="" data-link="<?php echo $model->getUri()?>" data-priceoff="<?php echo $model->getPriceOff();?>">
            <?php endforeach; ?>
        </div>                           
    </div>  
</div>