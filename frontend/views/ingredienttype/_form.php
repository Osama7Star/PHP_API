<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IngredientType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ingredient-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'e_name')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'a_name')->textInput(['maxlength' => true]) ?>    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
