<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeStepSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-step-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'recipe_step_id') ?>

    <?= $form->field($model, 'recipe_id') ?>

    <?= $form->field($model, 'step_number') ?>

    <?= $form->field($model, 'instruction') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
