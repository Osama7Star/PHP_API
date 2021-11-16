<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipeStepIngredientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recipe Step Ingredients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-step-ingredient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Recipe Step Ingredient', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'recipe_step_ingredient_id',
            'step_number',
            'ingredint_id',
            'alternative',
            'measure_unit',
            //'amount',
            //'recipe_step_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
