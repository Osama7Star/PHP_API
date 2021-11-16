<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "recipe_step_instruction".
 *
 * @property int $recipe_step_instruction_id
 * @property int $recipe_step_id
 * @property string $text
 *
 * @property RecipeStep $recipeStep
 */
class RecipeStepInstruction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe_step_instruction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['recipe_step_id'], 'integer'],
            [['text'], 'string', 'max' => 200],
            [['recipe_step_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecipeStep::className(), 'targetAttribute' => ['recipe_step_id' => 'recipe_step_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_step_instruction_id' => 'Recipe Step Instruction ID',
            'recipe_step_id' => 'Recipe Step ID',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeStep()
    {
        return $this->hasOne(RecipeStep::className(), ['recipe_step_id' => 'recipe_step_id']);
    }
}
