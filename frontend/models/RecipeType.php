<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "recipe_type".
 *
 * @property int $recipe_type_id
 * @property string $name
 *
 * @property Recipe[] $recipes
 */
class RecipeType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_type_id' => 'Recipe Type ID',
            'name' => 'Recipe Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['type' => 'recipe_type_id']);
    }
}
