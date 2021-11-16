<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Ingredient;

/**
 * IngredientSearch represents the model behind the search form of `frontend\models\Ingredient`.
 */
class IngredientSearch extends Ingredient
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ingredient_id'], 'integer'],
            [['e_name','a_name','ingredient_type_id'], 'safe'],
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
        $query = Ingredient::find();

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

        $query->joinWith('ingredientType');
        
        // grid filtering conditions
        $query->andFilterWhere([
            'ingredient_id' => $this->ingredient_id,
//            'ingredient_type_id' => $this->ingredient_type_id,
        ]);

        $query->andFilterWhere(['like', 'ingredient.a_name', $this->a_name]);
        $query->andFilterWhere(['like', 'ingredient.e_name', $this->e_name]);
        $query->andFilterWhere(['like', 'ingredient_type.e_name', $this->ingredient_type_id]);

        return $dataProvider;
    }
}
