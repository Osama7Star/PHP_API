<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecipeType */

$this->title = 'Create Recipe Type';
$this->params['breadcrumbs'][] = ['label' => 'Recipe Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
