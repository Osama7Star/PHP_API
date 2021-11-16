<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Foodstuff */

$this->title = 'Create Foodstuff';
$this->params['breadcrumbs'][] = ['label' => 'Foodstuffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foodstuff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
