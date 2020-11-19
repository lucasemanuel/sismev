<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VariationAttribute;

/**
 * VariationAttributeSearch represents the model behind the search form of `app\models\VariationAttribute`.
 */
class VariationAttributeSearch extends VariationAttribute
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['variation_set_id'], 'integer'],
            [['name'], 'safe'],
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
        $query = VariationAttribute::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes = array_merge($dataProvider->sort->attributes, [
            'variation_set_id' => [
                'asc' => ['variation_set.name' => SORT_ASC],
                'desc' => ['variation_set.name' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'variation_set_id' => $this->variation_set_id,
        ]);

        $query->andFilterWhere(['like', 'variation_attribute.name', $this->name]);

        return $dataProvider;
    }
}
