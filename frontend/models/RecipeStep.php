<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "recipe_step".
 *
 * @property int $recipe_step_id
 * @property int $recipe_id
 * @property int $step_number
 *
 * @property Recipe $recipe
 * @property RecipeStepIngredient[] $recipeStepIngredients
 * @property RecipeStepInstruction[] $recipeStepInstruction
 */
class RecipeStep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
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
            [['step_number'], 'required'],
            [['recipe_id', 'step_number'], 'integer'],            
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'recipe_id']],
            [['file'],'file'],
            [['image'], 'string', 'max' => 200],
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
            'image' => 'Image',
            'file' => 'Image',
        ];
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
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeStepInstructions()
    {
        return $this->hasMany(RecipeStepInstruction::className(), ['recipe_step_id' => 'recipe_step_id']);
    }
    
    
    public function beforeDelete() {
      foreach($this->recipeStepIngredients as $recipeStepIngredients)
            $recipeStepIngredients->delete();
        
      foreach($this->recipeStepInstructions as $recipeStepInstructions)
            $recipeStepInstructions->delete();    

      // call the parent implementation so that this event is raise properly
      return parent::beforeDelete();
    }
}
