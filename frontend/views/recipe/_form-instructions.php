
<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\models\Instruction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\RecipeStepInstruction;
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner2',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 7,
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
//    'model' => (empty($modelsStepInstruction)) ? $modelsStepInstruction[0] : $modelsStepInstruction[0],
    'model' => $modelsStepInstruction[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'desc'
    ],
]); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Instruction</th>
            <th class="text-center">
                <button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-rooms">
    <?php foreach ($modelsStepInstruction as $indexStepInstruction => $modelStepInstruction): ?>
        <tr class="room-item">
            <td class="vcenter">
                <?php
                    // necessary for update action.
                    if (! $modelStepInstruction->isNewRecord) {
                        echo Html::activeHiddenInput($modelStepInstruction, "[{$indexRecipeStep}][{$indexStepInstruction}]recipe_step_instruction_id");
                    }
                ?>                
                <?= $form->field($modelStepInstruction, "[{$indexRecipeStep}][{$indexStepInstruction}]text")->label(true)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="text-center vcenter" style="width: 90px;">
                <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>