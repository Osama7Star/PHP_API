<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Recipecategory;
use frontend\models\Recipetype;
use frontend\models\Recipestepingriedent;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">

<!--    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>-->
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'id' => 'dynamic-form']); ?>

     <div class="row">
       


        <div class="col-sm-3">
            <?= $form->field($modelRecipe, 'a_name')->textInput(['maxlength' => true]) ?>
        </div>        
        <div class="col-sm-3">
            <?= $form->field($modelRecipe, 'e_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($modelRecipe, 'a_small_desc')->textInput(['maxlength' => true]) ?>
        </div>        
        <div class="col-sm-3">
            <?= $form->field($modelRecipe, 'e_small_desc')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($modelRecipe, 'a_desc')->textarea(['maxlength' => true , 'rows' => '6']) ?>
        </div>        
        <div class="col-sm-6">
            <?= $form->field($modelRecipe, 'e_desc')->textarea(['maxlength' => true , 'rows' => '6']) ?>
        </div>
        <div class="col-sm-3 ">
           <?= $form->field($modelRecipe , 'file')->fileInput(['class' => 'custom-file-input']);?>
         </div>
        <div class="col-sm-3">                
        <?=  $form->field($modelRecipe,
            "category_id")->widget(Select2::classname(), 
            ['data' => ArrayHelper::map(Recipecategory::find()->all(),'recipe_category_id','e_name'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select a Recipe Category'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>        
        </div>
        <div class="col-sm-3">                
        <?=  $form->field($modelRecipe,
            "type_id")->widget(Select2::classname(), 
            ['data' => ArrayHelper::map(Recipetype::find()->all(),'recipe_type_id','name'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select a Recipe Type'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>        
        </div>
        <div class="col-sm-3">
            <?= $form->field($modelRecipe, 'calories')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($modelRecipe, 'person_count')->textInput(['maxlength' => true]) ?>
        </div> 
        <div class="col-sm-3">
            <?= $form->field($modelRecipe, 'period')->textInput(['maxlength' => true]) ?>
        </div>         
    </div>

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-steps',
        'widgetItem' => '.recipe-step',
        'limit' => 7,
        'min' => 1,
        'insertButton' => '.add-recipe',
        'deleteButton' => '.remove-recipe',
        'model' => $modelsRecipeStep[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'desc',
        ],
    ]); ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Steps</th>
                <th style="width: 250px;">Ingredients</th>
                <th style="width: 250px;">Instructions</th>
                <th class="text-center" style="width: 90px;">
                    <button type="button" class="add-recipe btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                </th>
            </tr>
        </thead>
        <tbody class="container-steps">
        <?php foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep): ?>
            <tr class="recipe-step">
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $modelRecipeStep->isNewRecord) {
                            echo Html::activeHiddenInput($modelRecipeStep, "[{$indexRecipeStep}]recipe_step_id");
                        }
                    ?>
                    <?= $form->field($modelRecipeStep, "[{$indexRecipeStep}]step_number")->label(false)->textInput(['maxlength' => true]) ?>
                                                              
                    <div class="col-sm-3 ">
                       <?= $form->field($modelRecipeStep , "[{$indexRecipeStep}]file")->fileInput(['class' => 'custom-file-input']);?>
                     </div>
                                                               
                </td>
                
                <td>
                    <?= $this->render('_form-instructions', [
                        'form' => $form,
                        'indexRecipeStep' => $indexRecipeStep,
                        'modelsStepInstruction' => $modelsStepInstruction[$indexRecipeStep],
                    ]) ?>
                </td>

                <td>
                    <?= $this->render('_form-steps', [
                        'form' => $form,
                        'indexRecipeStep' => $indexRecipeStep,
                        'modelsStepIngredient' => $modelsStepIngredient[$indexRecipeStep],
                    ]) ?>
                </td>                
                
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-recipe btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
            
         <?php endforeach; ?>
        </tbody>
    </table>
    <?php DynamicFormWidget::end(); ?>
    
    <div class="form-group">
        <?= Html::submitButton($modelRecipe->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>