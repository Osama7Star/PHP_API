<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeStepIngredient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-step-ingredient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'step_number')->textInput() ?>

    <?= $form->field($model, 'ingredint_id')->textInput() ?>

    <?= $form->field($model, 'alternative')->textInput() ?>

    <?= $form->field($model, 'measure_unit')->dropDownList([ 'KG' => 'KG', 'Unit' => 'Unit', 'Liter' => 'Liter', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'recipe_step_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
