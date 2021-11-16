<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "food_stuff".
 *
 * @property int $id
 * @property string $name
 * @property int $type_id
 * @property string $image
 *
 * @property FoodType $type
 */
class FoodStuff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'food_stuff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'image'], 'required'],
            [['type_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 200],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FoodType::className(), 'targetAttribute' => ['type_id' => 'id']],
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
            'type_id' => 'Type ID',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(FoodType::className(), ['id' => 'type_id']);
    }
}
