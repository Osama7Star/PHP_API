<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\IngredientType;

/**
 * IngredientTypeSearch represents the model behind the search form of `frontend\models\IngredientType`.
 */
class IngredientTypeSearch extends IngredientType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ingredient_type_id'], 'integer'],
            [['a_name','e_name'], 'safe'],
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
        $query = IngredientType::find();

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
            'ingredient_type_id' => $this->ingredient_type_id,
        ]);

        $query->andFilterWhere(['like', 'a_name', $this->a_name]);
        $query->andFilterWhere(['like', 'e_name', $this->e_name]);

        return $dataProvider;
    }
}
