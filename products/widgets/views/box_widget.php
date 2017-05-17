<div class="product-box-container"> 
    <div class="panel panel-tile  br-a br-light">
        <div class="panel-body bg-light dark"> 
            <?php echo $model->getThumbToViewTag(['data-pjax' => '0']); ?>  
            <div class="panel panel-tile text-center br-a br-light hidden popup">
                <div class="panel-body bg-light dark"> 
                    <div class="">
                        <div class="col-md-4 pl0">  
                            <div class="middle-thumb-container"> 
                                <?php echo $model->getThumbToViewTag(['data-pjax' => '0']); ?>       
                            </div>                    
                            <p class="strong-black-upper">
                                <?php echo $model->getName(); ?>                            
                            </p>
                            <p class="strong-black-upper">
                                <?php echo $model->getFormatsString(); ?>                            
                            </p>

                        </div>
                        <div class="col-md-5">

                            <table class="table">
                                <tr>
                                    <td>Published</td>
                                    <td><?php echo $model->getPublished(); ?></td>                                        
                                </tr>
                                <tr>                                      
                                    <td>Geometry</td>
                                    <td><?php echo $model->getGeometry(); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>Polygons</td>
                                    <td><?php echo $model->getAttributeByName('polygons'); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>Vertices</td>
                                    <td><?php echo $model->getAttributeByName('vertices'); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>Textures</td>
                                    <td><?php echo $model->getBoolAttributeByName('textures'); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>Materials</td>
                                    <td><?php echo $model->getBoolAttributeByName('materials'); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>Rigged</td>
                                    <td><?php echo $model->getBoolAttributeByName('rigged'); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>Animated</td>
                                    <td><?php echo $model->getBoolAttributeByName('animated'); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>UV Mapped</td>
                                    <td><?php echo $model->getBoolAttributeByName('uv_mapped'); ?></td> 
                                </tr>
                                <tr>                                      
                                    <td>Unwrapped UVs</td>
                                    <td><?php echo $model->getUnwrappedUVs(); ?></td> 
                                </tr>


                            </table>
                        </div>
                        <div class="col-md-3">                                       
                            <div class="pricing-table mtn">
                                <div class="pricing-plan plan-info mtn">
                                    <div class="plan-pricing">                                       
                                        <h2 class="fs24"><?php echo $model->getCurrencyPriceWithOff2(); ?></h2>
                                    </div>                          
                                    <div class="plan-features">
                                        <ul>
                                            <li>
                                                <strong><?php echo Yii::t('app', 'Owner') ?>:</strong> <?php echo $model->getUserNamesToViewTag(['data-pjax' => '0']); ?>
                                            </li> 
                                            <li>
                                                <strong>Software:</strong> <?php echo $model->getSoftwareString(); ?>
                                            </li> 
                                            <li>
                                                <strong><?php echo Yii::t('app', 'Engines') ?>:</strong> <?php echo $model->getEnginesString(); ?>
                                            </li> 
                                            <li>
                                                <strong>Formats:</strong> <?php echo $model->getFormatsString(); ?>
                                            </li>                                   
                                        </ul>
                                    </div>
                                    <div class="plan-footer">
                                        <button type="button" class="btn add-to-cart ladda-button btn-warning" data-style="zoom-in" data-product="<?php echo $model->id; ?>">
                                            <span class="ladda-label">Add to Cart</span>
                                            <span class="ladda-spinner"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="panel-footer bg-white br-t br-light p12">
            <div class="row">
                <div class="col-md-12">
                     <span class="fs11 clearfix">
                        <div class='info-name'>
                            <?php echo $model->getName(); ?>     
                        </div>
                        <div class='info-formats'>
                            <?php echo $model->getFormatsString(); ?>   
                        </div>  
                       
                    </span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <hr class="black-bottom">
                    <span class="clearfix info-price">                     
                        <b><?php echo $model->getCurrencyPriceWithOff(); ?></b>
                    </span>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn add-to-cart ladda-button btn-warning" data-style="zoom-in" data-product="<?php echo $model->id; ?>">
                        <span class="fa fa-shopping-cart fs20 ladda-label"></span><span class="plus-char">+</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>


        </div>
    </div>
</div>