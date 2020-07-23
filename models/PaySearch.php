<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pay;

/**
 * PaySearch represents the model behind the search form of `app\models\Pay`.
 */
class PaySearch extends Pay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'installments', 'payment_method_id', 'sale_id'], 'integer'],
            [['value'], 'number'],
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
        $query = Pay::find();

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
            'value' => $this->value,
            'installments' => $this->installments,
            'payment_method_id' => $this->payment_method_id,
            'sale_id' => $this->sale_id,
        ]);

        return $dataProvider;
    }
}
