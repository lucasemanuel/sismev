<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Address;

/**
 * AddressSearch represents the model behind the search form of `app\models\Address`.
 */
class AddressSearch extends Address
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['zip_code', 'number', 'street', 'neighborhood', 'city', 'federated_unit', 'complement'], 'safe'],
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
        $query = Address::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'neighborhood', $this->neighborhood])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'federated_unit', $this->federated_unit])
            ->andFilterWhere(['like', 'complement', $this->complement]);

        return $dataProvider;
    }
}
