<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `app\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_sold', 'is_canceled', 'order_id'], 'integer'],
            [['amount_paid', 'discount'], 'number'],
            [['sale_at', 'canceled_at', 'updated_at'], 'safe'],
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
        $query = Sale::find();

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
            'amount_paid' => $this->amount_paid,
            'discount' => $this->discount,
            'is_sold' => $this->is_sold,
            'is_canceled' => $this->is_canceled,
            'sale_at' => $this->sale_at,
            'canceled_at' => $this->canceled_at,
            'updated_at' => $this->updated_at,
            'order_id' => $this->order_id,
        ]);

        return $dataProvider;
    }
}
