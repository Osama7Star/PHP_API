<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RecipeStepIngredient;

/**
 * RecipeStepIngredientSearch represents the model behind the search form of `app\models\RecipeStepIngredient`.
 */
class RecipeStepIngredientSearch extends RecipeStepIngredient
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_step_ingredient_id', 'step_number', 'ingredint_id', 'alternative', 'amount', 'recipe_step_id'], 'integer'],
            [['measure_unit'], 'safe'],
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
        $query = RecipeStepIngredient::find();

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
            'recipe_step_ingredient_id' => $this->recipe_step_ingredient_id,
            'step_number' => $this->step_number,
            'ingredint_id' => $this->ingredint_id,
            'alternative' => $this->alternative,
            'amount' => $this->amount,
            'recipe_step_id' => $this->recipe_step_id,
        ]);

        $query->andFilterWhere(['like', 'measure_unit', $this->measure_unit]);

        return $dataProvider;
    }
}
