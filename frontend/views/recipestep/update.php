<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeStep */

$this->title = 'Update Recipe Step: ' . $model->recipe_step_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Steps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recipe_step_id, 'url' => ['view', 'id' => $model->recipe_step_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-step-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
