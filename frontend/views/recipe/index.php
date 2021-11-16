<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recipes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Recipe', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'recipe_id',
            'a_name',
            'e_name',
//            'a_desc',
//            'e_desc',
//            'a_small_desc',
//            'e_small_desc',
            [
                'attribute' => 'type_id',
                'value' => 'type.name',
            ],
//            'type.name',
            'person_count',
            [
                'attribute' => 'category_id',
                'value' => 'category.e_name',
            ],
//            'category.e_name',
//            'image',
            'period',
//            'calories',
//            'creation_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
