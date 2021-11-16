<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\RecipeStep;

/**
 * RecipeStepSearch represents the model behind the search form of `app\models\RecipeStep`.
 */
class RecipeStepSearch extends RecipeStep
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_step_id', 'recipe_id', 'step_number'], 'integer'],
            [['instruction'], 'safe'],
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
        $query = RecipeStep::find();

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
            'recipe_step_id' => $this->recipe_step_id,
            'recipe_id' => $this->recipe_id,
            'step_number' => $this->step_number,
        ]);

        $query->andFilterWhere(['like', 'instruction', $this->instruction]);

        return $dataProvider;
    }
}
