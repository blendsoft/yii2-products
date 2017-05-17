<?php

use app\modules\products\models\ProductCompat;
use app\modules\products\models\ProductFileFormat;
use app\modules\products\models\ProductGameEngine;
use yii\widgets\ActiveForm;
?>



<?php
$form = ActiveForm::begin([
            'id' => 'filter-form',
            'options' => ['class' => 'controls']
        ])
?>

<div class="row">   
    <div class="btn-group  col-md-4">   
       
            <fieldset> 
                <?php
                echo $form->field($model, 'tmpSoftwares', [
                    'template' => '{input}',
                ])->dropdownList(
                        ProductCompat::find()->select(['name', 'id'])->indexBy('id')->column(), [
                    'prompt' => 'Software',
                        ]
                );
                ?>
            </fieldset>
       
    </div>

    <div class="btn-group  col-md-4">

       
            <fieldset> 
                <?php
                echo $form->field($model, 'tmpFormats', [
                    'template' => '{input}',
                ])->dropdownList(
                        ProductFileFormat::find()->select(['name', 'id'])->indexBy('id')->column(), [
                    'prompt' => 'Format',
                    'multiple' => false,
                        ]
                );
                ?>
            </fieldset>
        
    </div>   

    <div class="btn-group  col-md-4">

     
            <fieldset> 
                <?php
                echo $form->field($model, 'tmpEngines', [
                    'template' => '{input}',
                ])->dropdownList(
                        ProductGameEngine::find()->select(['name', 'id'])->indexBy('id')->column(), [
                    'prompt' => 'Engine',
                    'multiple' => false,
                        ]
                );
                ?>
            </fieldset>
       
    </div>  
</div>

<?php ActiveForm::end() ?>