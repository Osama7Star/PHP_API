<?php

namespace frontend\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "recipe_category".
 *
 * @property int $recipe_category_id
 * @property string $name
 *
 * @property Recipe[] $recipes
 */
class RecipeCategory extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['e_name', 'a_name'], 'required'],
            [['e_name','a_name'], 'string', 'max' => 100],
            [['file'],'file'],
            [['image','a_desc','e_desc'], 'string', 'max' => 200],
        ];
    }
    
//    public function fields()
//    {
//        return ['a_name','e_name','image'];
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_category_id' => 'Recipe Category ID',
            'a_name' => 'A Kitchen Name',
            'e_name' => 'E Kitchen Name',
            'e_desc' => 'English Description',
            'a_desc' => 'Arabic Description',
            'image' => 'Image',
            'file' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['category_id' => 'recipe_category_id']);
    }
}
