<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "recipe_step_ingredient".
 *
 * @property int $recipe_step_ingredient_id
 * @property int $step_number
 * @property int $ingredient_id
 * @property int $alternative
 * @property string $measure_unit
 * @property int $amount
 * @property int $recipe_step_id
 *
 * @property Ingredient $ingredint
 * @property RecipeStep $recipeStep
 */
class RecipeStepIngredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe_step_ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ingredient_id', 'measure_unit', 'amount'], 'required'],
            [['ingredient_id', 'alternative', 'amount', 'recipe_step_id'], 'integer'],
            [['measure_unit'], 'string'],
            [['ingredient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredient::className(), 'targetAttribute' => ['ingredient_id' => 'ingredient_id']],
            [['recipe_step_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecipeStep::className(), 'targetAttribute' => ['recipe_step_id' => 'recipe_step_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_step_ingredient_id' => 'Recipe Step Ingredient ID',            
            'ingredient_id' => 'Ingredint ID',
            'alternative' => 'Alternative',
            'measure_unit' => 'Measure Unit',
            'amount' => 'Amount',
            'recipe_step_id' => 'Recipe Step ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredint()
    {
        return $this->hasOne(Ingredient::className(), ['ingredient_id' => 'ingredient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeStep()
    {
        return $this->hasOne(RecipeStep::className(), ['recipe_step_id' => 'recipe_step_id']);
    }
}
