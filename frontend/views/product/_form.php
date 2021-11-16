<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Product;
use frontend\models\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model , 'image')->fileInput();?>

    <?= $form->field($model, 'price')->textInput() ?>

    <!-- <?= $form->field($model, 'category_id')->textInput() ?> -->

    <?=  $form->field($model,
            "category_id")->widget(Select2::classname(), 
            ['data' => ArrayHelper::map(Category::find()->all(),'id','name'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select Ingredient Type'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
