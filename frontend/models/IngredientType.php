<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ingredient_type".
 *
 * @property int $ingredient_type_id
 * @property string $a_name
 * @property string $e_name
 *
 * @property Ingredient[] $ingredients
 */
class IngredientType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['a_name','e_name'], 'required'],
            [['a_name','e_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ingredient_type_id' => 'Ingredient Type ID',
            'a_name' => 'A Ingrident Type',
            'e_name' => 'E Ingrident Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['ingredient_type_id' => 'ingredient_type_id']);
    }
}
