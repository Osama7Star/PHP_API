<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = $model->recipe_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="recipe-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'recipe_id' => $model->recipe_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'recipe_id' => $model->recipe_id], [
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
            'recipe_id',
            'a_name',
            'e_name',
            'a_desc',
            'e_desc',
            'a_small_desc',
            'e_small_desc',
            'type_id',
            'person_count',
            'category_id',
            'image',
            'period',
            'calories',
            'creation_date',
        ],
    ]) ?>

</div>
