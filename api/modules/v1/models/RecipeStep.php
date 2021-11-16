<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "recipe_step".
 *
 * @property int $recipe_step_id
 * @property int $recipe_id
 * @property int $step_number
 * @property string $instruction
 *
 * @property Recipe $recipe
 * @property RecipeStepIngredient[] $recipeStepIngredients
 */
class RecipeStep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['step_number', 'instruction'], 'required'],
            [['recipe_id', 'step_number'], 'integer'],
            [['instruction'], 'string'],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'recipe_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_step_id' => 'Recipe Step ID',
            'recipe_id' => 'Recipe ID',
            'step_number' => 'Step Number',
            'instruction' => 'Instruction',
        ];
    }
    
    
    public function fields()
    {
        return ['instruction'];
    }
    
    public function extraFields()
    {
        return ['recipeStepIngredients'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['recipe_id' => 'recipe_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeStepIngredients()
    {
        return $this->hasMany(RecipeStepIngredient::className(), ['recipe_step_id' => 'recipe_step_id']);
    }
}
