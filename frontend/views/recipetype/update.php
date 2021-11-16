<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeType */

$this->title = 'Update Recipe Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->recipe_type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
