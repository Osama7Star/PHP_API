<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "ingredient_type".
 *
 * @property int $ingredient_type_id
 * @property string $name
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
            'ingredient_type_id' => 'Ingredient Type ID',
            'name' => 'Name',
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
