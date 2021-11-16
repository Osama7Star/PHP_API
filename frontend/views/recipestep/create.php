<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecipeStep */

$this->title = 'Create Recipe Step';
$this->params['breadcrumbs'][] = ['label' => 'Recipe Steps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-step-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
