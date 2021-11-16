<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "recipe".
 *
 * @property int $recipe_id
 * @property string $a_name
 * @property string $e_name
 * @property string $a_desc
 * @property string $e_desc
 * @property string $a_small_desc
 * @property string $e_small_desc
 * @property int $type_id
 * @property int $person_count
 * @property int $category_id
 * @property string $image
 * @property string $calories
 * @property string $period
 *
 * @property RecipeCategory $category
 * @property RecipeType $type
 * @property RecipeImage[] $recipeImages
 * @property RecipeStep[] $recipeSteps
 */
class Recipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['a_name', 'e_name','category_id'], 'required'],
//            [['a_name', 'e_name', 'a_desc', 'e_desc', 'a_small_desc', 'e_small_desc', 'type_id', 'person_count', 'category_id', 'image'], 'required'],
            [['type_id', 'person_count', 'category_id','calories','period'], 'integer'],
            [['a_name', 'e_name'], 'string', 'max' => 100],
            [['e_small_desc','a_small_desc'], 'string', 'max' => 250],
            [['a_desc','e_desc'], 'string', 'max' => 500],
            [['file'],'file'],
//            [['creation_date'],'creation_date'],
            [['image'], 'string', 'max' => 200],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecipeCategory::className(), 'targetAttribute' => ['category_id' => 'recipe_category_id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecipeType::className(), 'targetAttribute' => ['type_id' => 'recipe_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recipe_id' => 'Recipe ID',
            'a_name' => 'A Name',
            'e_name' => 'E Name',
            'a_desc' => 'A Desc',
            'e_desc' => 'E Desc',
            'a_small_desc' => 'A Small Desc',
            'e_small_desc' => 'E Small Desc',
            'type_id' => 'Recipe Type',
            'person_count' => 'Person Count',
            'category_id' => 'Kitchen Name',
            'image' => 'Image',
            'file' => 'Image',
            'period' => 'Period',
            'calories' => 'Calories',
            'creation_date' => 'creation_date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(RecipeCategory::className(), ['recipe_category_id' => 'category_id']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(RecipeType::className(), ['recipe_type_id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeImages()
    {
        return $this->hasMany(RecipeImage::className(), ['recipe_id' => 'recipe_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeSteps()
    {
        return $this->hasMany(RecipeStep::className(), ['recipe_id' => 'recipe_id']);
    }       
    
    public function beforeDelete() {
        foreach($this->recipeSteps as $recipeStep)
            $recipeStep->delete();

      // call the parent implementation so that this event is raise properly
      return parent::beforeDelete();
    }
    
    
}
