<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecipeImage */

$this->title = 'Create Recipe Image';
$this->params['breadcrumbs'][] = ['label' => 'Recipe Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
