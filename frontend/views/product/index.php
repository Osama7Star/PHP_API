<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'image',
            'price',
            'category_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{indirim} {view} {update} {delete}',
                'buttons'=>[

                    'indirim' => function ($url, $model) {     

                          return Html::a('<span class="glyphicon glyphicon-download"></span>', $url, [

                              'title' => Yii::t('yii', 'Indirim'),

                          ]);                                

                      }

                  ],
            ],
        ],
    ]); ?>
</div>
