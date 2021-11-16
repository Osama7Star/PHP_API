<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RecipeStepInstruction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-step-instruction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recipe_step_id')->textInput() ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
