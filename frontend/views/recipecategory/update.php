<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeCategory */

$this->title = 'Update Recipe Category: ' . $model->e_name;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->e_name, 'url' => ['view', 'id' => $model->recipe_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
