<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredient */

$this->title = 'Update Ingredient: ' . $model->e_name;
$this->params['breadcrumbs'][] = ['label' => 'Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->e_name, 'url' => ['view', 'id' => $model->ingredient_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ingredient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
