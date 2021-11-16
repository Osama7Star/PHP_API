<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeImage */

$this->title = 'Update Recipe Image: ' . $model->recipe_image_id;
$this->params['breadcrumbs'][] = ['label' => 'Recipe Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recipe_image_id, 'url' => ['view', 'id' => $model->recipe_image_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
