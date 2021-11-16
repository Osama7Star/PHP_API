<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IngredientTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ingredient Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ingredient Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ingredient_type_id',
            'a_name',
            'e_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
