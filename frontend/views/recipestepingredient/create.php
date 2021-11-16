<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecipeStepIngredient */

$this->title = 'Create Recipe Step Ingredient';
$this->params['breadcrumbs'][] = ['label' => 'Recipe Step Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-step-ingredient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
