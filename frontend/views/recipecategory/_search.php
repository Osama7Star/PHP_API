<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'recipe_category_id') ?>

    <?= $form->field($model, 'e_name') ?>
    
    <?= $form->field($model, 'a_name') ?>
    
    <?= $form->field($model, 'a_desc') ?>
    
    <?= $form->field($model, 'e_desc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
