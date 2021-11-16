<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "food_type".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 *
 * @property FoodStuff[] $foodStuffs
 */
class FoodType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'food_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodStuffs()
    {
        return $this->hasMany(FoodStuff::className(), ['type_id' => 'id']);
    }
}
