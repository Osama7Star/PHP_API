<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $ingredient_id
 * @property string $name
 * @property int $ingredient_type_id
 *
 * @property IngredientType $ingredientType
 * @property RecipeStepIngredient[] $recipeStepIngredients
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['e_name', 'ingredient_type_id'], 'required'],
            [['ingredient_id'], 'integer'],
            [['a_name','e_name'], 'string', 'max' => 100],
            [['ingredient_id'], 'unique'],
            [['file'],'file'],
            [['image'], 'string', 'max' => 200],
            [['ingredient_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => IngredientType::className(), 'targetAttribute' => ['ingredient_type_id' => 'ingredient_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ingredient_id' => 'Ingredient ID',
            'e_name' => 'English Name',
            'a_name' => 'Arabic Name',
            'ingredient_type_id' => 'Ingredient Type',
            'image' => 'Image',
            'file' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredientType()
    {
        return $this->hasOne(IngredientType::className(), ['ingredient_type_id' => 'ingredient_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeStepIngredients()
    {
        return $this->hasMany(RecipeStepIngredient::className(), ['ingredint_id' => 'ingredient_id']);
    }
}
