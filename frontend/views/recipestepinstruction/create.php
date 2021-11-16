<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\RecipeStepInstruction */

$this->title = 'Create Recipe Step Instruction';
$this->params['breadcrumbs'][] = ['label' => 'Recipe Step Instructions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-step-instruction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
