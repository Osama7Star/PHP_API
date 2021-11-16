<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = 'Create Recipe';
$this->params['breadcrumbs'][] = ['label' => 'Recipes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [    
        'modelRecipe' => $modelRecipe,
        'modelsRecipeStep' => (empty($modelsRecipeStep)) ? [new RecipeStep] : $modelsRecipeStep,
        'modelsStepInstruction' => (empty($modelsStepInstruction)) ? [[new RecipeStepInstruction]] : $modelsStepInstruction,
        'modelsStepIngredient' => (empty($modelsStepIngredient)) ? [[new RecipeStepIngredient]] : $modelsStepIngredient,        
    ]) ?>

</div>
