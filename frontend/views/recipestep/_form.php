<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeStep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-step-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recipe_id')->textInput() ?>

    <?= $form->field($model, 'step_number')->textInput() ?>

    <?= $form->field($model, 'instruction')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
