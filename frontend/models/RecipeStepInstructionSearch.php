<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\RecipeStepInstruction;

/**
 * RecipeStepInstructionSearch represents the model behind the search form of `frontend\models\RecipeStepInstruction`.
 */
class RecipeStepInstructionSearch extends RecipeStepInstruction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_step_instruction_id', 'recipe_step_id'], 'integer'],
            [['text'], 'safe'],
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
        $query = RecipeStepInstruction::find();

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
            'recipe_step_instruction_id' => $this->recipe_step_instruction_id,
            'recipe_step_id' => $this->recipe_step_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
