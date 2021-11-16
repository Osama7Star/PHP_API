<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'recipe_id') ?>

    <?= $form->field($model, 'a_name') ?>

    <?= $form->field($model, 'e_name') ?>

    <?= $form->field($model, 'a_desc') ?>

    <?= $form->field($model, 'e_desc') ?>

    <?php // echo $form->field($model, 'a_small_desc') ?>

    <?php // echo $form->field($model, 'e_small_desc') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'person_count') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'image') ?>
    
    
    <?php  echo $form->field($model, 'creation_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
