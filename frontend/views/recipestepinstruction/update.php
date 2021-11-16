<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RecipeStepInstruction */

$this->title = 'Update Recipe Step Instruction: ' . $model->recipe_step_instruction_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Step Instructions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recipe_step_instruction_id, 'url' => ['view', 'id' => $model->recipe_step_instruction_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-step-instruction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
