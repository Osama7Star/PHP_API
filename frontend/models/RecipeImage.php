<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "recipe_image".
 *
 * @property int $recipe_image_id
 * @property string $image_url
 * @property int $recipe_id
 *
 * @property Recipe $recipe
 */
class RecipeImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_image_id', 'image_url', 'recipe_id'], 'required'],
            [['recipe_image_id', 'recipe_id'], 'integer'],
            [['image_url'], 'string', 'max' => 250],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'recipe_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_image_id' => 'Recipe Image ID',
            'image_url' => 'Image Url',
            'recipe_id' => 'Recipe ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['recipe_id' => 'recipe_id']);
    }
}
