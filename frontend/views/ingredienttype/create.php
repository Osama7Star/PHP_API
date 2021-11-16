<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\IngredientType */

$this->title = 'Create Ingredient Type';
$this->params['breadcrumbs'][] = ['label' => 'Ingredient Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
