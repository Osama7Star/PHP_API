<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeStepIngredient */

$this->title = $model->recipe_step_ingredient_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Step Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="recipe-step-ingredient-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->recipe_step_ingredient_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->recipe_step_ingredient_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'recipe_step_ingredient_id',
            'step_number',
            'ingredint_id',
            'alternative',
            'measure_unit',
            'amount',
            'recipe_step_id',
        ],
    ]) ?>

</div>
