<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RecipeCategory;

/**
 * RecipeCategorySearch represents the model behind the search form of `app\models\RecipeCategory`.
 */
class RecipeCategorySearch extends RecipeCategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_category_id'], 'integer'],
            [['e_name','a_name','image','a_desc','e_desc'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RecipeCategory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'recipe_category_id' => $this->recipe_category_id,
        ]);

        $query->andFilterWhere(['like', 'a_name', $this->a_name]);
        $query->andFilterWhere(['like', 'e_name', $this->e_name]);
        $query->andFilterWhere(['like', 'e_name', $this->e_desc]);
        $query->andFilterWhere(['like', 'e_name', $this->a_desc]);

        return $dataProvider;
    }
}
