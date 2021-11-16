<?php

namespace api\modules\v1\models;
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
            [['image'], 'string', 'max' => 200],
        ];
    }
    
    public function fields()
    {
        return ['a_name','e_name'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_category_id' => 'Recipe Category ID',
            'a_name' => 'Arabic Name',
            'e_name' => 'English Name',
            'image' => 'Image',
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
