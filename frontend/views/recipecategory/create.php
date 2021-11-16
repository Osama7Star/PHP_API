<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecipeCategory */

$this->title = 'Create Recipe Category';
$this->params['breadcrumbs'][] = ['label' => 'Recipe Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
