<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Ingredient;
use frontend\models\IngredientType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ingredient-form">

    <?php $form = ActiveForm::begin(); ?>    

    <?= $form->field($model, 'e_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'a_name')->textInput(['maxlength' => true]) ?>

<!--    <?= $form->field($model, 'ingredient_type_id')->textInput() ?>-->
                      
        <?=  $form->field($model,
            "ingredient_type_id")->widget(Select2::classname(), 
            ['data' => ArrayHelper::map(IngredientType::find()->all(),'ingredient_type_id','e_name'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select Ingredient Type'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>                
    
    
    <?= $form->field($model , 'file')->fileInput();?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
