<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeStepIngredient */

$this->title = 'Update Recipe Step Ingredient: ' . $model->recipe_step_ingredient_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Step Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recipe_step_ingredient_id, 'url' => ['view', 'id' => $model->recipe_step_ingredient_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-step-ingredient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
