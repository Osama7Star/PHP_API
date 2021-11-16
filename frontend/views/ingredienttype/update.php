<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IngredientType */

$this->title = 'Update Ingredient Type: ' . $model->e_name;
$this->params['breadcrumbs'][] = ['label' => 'Ingredient Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->e_name, 'url' => ['view', 'id' => $model->ingredient_type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ingredient-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
