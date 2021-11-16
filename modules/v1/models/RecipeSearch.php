<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Recipe;


/**
 * RecipeSearch represents the model behind the search form of `app\models\Recipe`.
 */
class RecipeSearch extends Recipe
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_id', 'type', 'person_count', 'category_id'], 'integer'],
            [['a_name', 'e_name', 'a_desc', 'e_desc', 'a_small_desc', 'e_small_desc', 'image','creation_date'], 'safe'],
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
        $query = Recipe::find();

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
            'recipe_id' => $this->recipe_id,
            'type' => $this->type,
            'person_count' => $this->person_count,
            'category_id' => $this->category_id,
            'creation_date' => $this->creation_date,
        ]);

        $query->andFilterWhere(['like', 'a_name', $this->a_name])
            ->andFilterWhere(['like', 'e_name', $this->e_name])
            ->andFilterWhere(['like', 'a_desc', $this->a_desc])
            ->andFilterWhere(['like', 'e_desc', $this->e_desc])
            ->andFilterWhere(['like', 'a_small_desc', $this->a_small_desc])
            ->andFilterWhere(['like', 'e_small_desc', $this->e_small_desc])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'creation_date', $this->creation_date]);

        return $dataProvider;
    }
}
