<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipeImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recipe Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Recipe Image', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'recipe_image_id',
            'image_url:url',
            'recipe_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
