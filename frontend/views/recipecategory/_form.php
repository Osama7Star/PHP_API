<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'e_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'a_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'e_desc')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'a_desc')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model , 'file')->fileInput();?>    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
