<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeStepIngredientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-step-ingredient-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'recipe_step_ingredient_id') ?>

    <?= $form->field($model, 'step_number') ?>

    <?= $form->field($model, 'ingredint_id') ?>

    <?= $form->field($model, 'alternative') ?>

    <?= $form->field($model, 'measure_unit') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'recipe_step_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
