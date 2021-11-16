
<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\models\Ingredient;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner1',
    'widgetBody' => '.container-ingridents',
    'widgetItem' => '.ingrident-item',
    'limit' => 7,
    'min' => 1,
    'insertButton' => '.add-ingrident',
    'deleteButton' => '.remove-ingrident',
    'model' => (empty($modelsStepIngredient)) ? $modelsStepIngredient[0] : $modelsStepIngredient[0],
//    'model' => $modelsStepIngredient[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'desc'
    ],
]); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Ingrident</th>
            <th class="text-center">
                <button type="button" class="add-ingrident btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-ingridents">
    <?php foreach ($modelsStepIngredient as $indexStepIngredient => $modelStepIngredient): ?>
        <tr class="ingrident-item">
            <td class="vcenter">
                <?php
                    // necessary for update action.
                    if (! $modelStepIngredient->isNewRecord) {
                        echo Html::activeHiddenInput($modelStepIngredient, "[{$indexRecipeStep}][{$indexStepIngredient}]recipe_step_ingredient_id");
                    }
                ?>
                <div class="col-sm-12">                
                <?=  $form->field($modelStepIngredient, "[{$indexRecipeStep}][{$indexStepIngredient}]ingredient_id")->widget(Select2::classname(), 
                    ['data' => ArrayHelper::map(Ingredient::find()->all(),'ingredient_id','e_name'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select an Ingridents'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>        
                </div>
                <?= $form->field($modelStepIngredient, "[{$indexRecipeStep}][{$indexStepIngredient}]amount")->label(false)->textInput(['maxlength' => true]) ?>
                <?= $form->field($modelStepIngredient, "[{$indexRecipeStep}][{$indexStepIngredient}]measure_unit")->dropDownList([ 'KG' => 'KG', 'Unit' => 'Unit', 'Liter' => 'Liter','cup' => 'cup','Teaspoon' =>'Teaspoon','pound' => 'pound','tablespoon'=>'tablespoon','clove' => 'clove'], ['prompt' => 'choose Unit']) ?>
            </td>
            <td class="text-center vcenter" style="width: 90px;">
                <button type="button" class="remove-ingrident btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>