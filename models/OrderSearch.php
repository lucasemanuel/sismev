<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    public $total_items;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_quotation', 'company_id', 'status'], 'integer'],
            [['code', 'note', 'created_at', 'updated_at'], 'safe'],
            [['total_value', 'total_items'], 'number'],
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
        $query = Order::find();

        // add conditions that should always apply here

        $query->select('order.*, sale.is_sold, sum(order_item.amount) as total_items')
            ->leftJoin('order_item', 'order.id = order_item.order_id')
            ->leftJoin('sale', 'order.id = sale.order_id')
            ->groupBy('order.id, sale.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes = array_merge($dataProvider->sort->attributes, [
            'total_items' => [
                'asc' => ['total_items' => SORT_ASC],
                'desc' => ['total_items' => SORT_DESC],
            ],
            'status' => [
                'asc' => ['is_sold' => SORT_ASC],
                'desc' => ['is_sold' => SORT_DESC],
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
            'id' => $this->id,
            'total_value' => $this->total_value,
            'is_quotation' => $this->is_quotation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
