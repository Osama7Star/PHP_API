<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RecipeStepInstructionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recipe Step Instructions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-step-instruction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Recipe Step Instruction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'recipe_step_instruction_id',
            'recipe_step_id',
            'text',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
