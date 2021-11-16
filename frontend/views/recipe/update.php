<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = 'Update Recipe: ' . $modelRecipe->recipe_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelRecipe->recipe_id, 'url' => ['view', 'id' => $modelRecipe->recipe_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [    
        'modelRecipe' => $modelRecipe,
        'modelsRecipeStep' => (empty($modelsRecipeStep)) ? [new RecipeStep] : $modelsRecipeStep,
        'modelsStepIngredient' => (empty($modelsStepIngredient)) ? [[new RecipeStepIngredient]] : $modelsStepIngredient,
        'modelsStepInstruction' => (empty($modelsStepInstruction)) ? [[new RecipeStepInstruction]] : $modelsStepInstruction,
    ]) ?>

</div>
