<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    public $total_items;
    public $status = [ 'sold', 'open' ];
    public $setting_search_total_items = 0;
    public $setting_search_total_value = 0;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'setting_search_total_items', 'setting_search_total_value'], 'integer'],
            [['code', 'created_at', 'updated_at', 'status'], 'safe'],
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
            'updated_at' => $this->updated_at,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

        $this->filterDate($query);
        $this->filterTotalValue($query);
        $this->filterTotalItems($query);
        $this->filterStatus($query);

        return $dataProvider;
    }

    private function filterDate(ActiveQuery &$query)
    {
        if (!empty($this->created_at)) {
            $dates = explode(" - ", $this->created_at);
            $start = Yii::$app->formatter->asDateTimeDefault($dates[0]);
            $end = Yii::$app->formatter->asDateTimeDefault($dates[1]);

            $query->andFilterWhere(['between', 'order.created_at', $start, $end]);
        }
    }

    private function filterTotalValue(ActiveQuery &$query)
    {
        $operator = '=';
        if (isset($this->total_value)) {
            if ($this->setting_search_total_value == 1)
                $operator = '>=';
            else if ($this->setting_search_total_value == 2)
                $operator = '<=';
        }

        $query->andFilterWhere([$operator, 'total_value', $this->total_value]);
    }

    private function filterTotalItems(ActiveQuery &$query)
    {
        $operator = '=';
        if (isset($this->total_items)) {
            if ($this->setting_search_total_items == 1)
                $operator = '>=';
            else if ($this->setting_search_total_items == 2)
                $operator = '<=';
        }
        
        $query->andFilterHaving([$operator, 'total_items', $this->total_items]);
    }

    private function filterStatus(ActiveQuery &$query)
    {
        if (!empty($this->status) && count($this->status) < 2) {
            $value = current($this->status);
            
            if ($value == 'sold') {
                $query->andFilterWhere(['sale.is_sold' => 1]);
            } else {
                $subQuery = Order::find()->select('order.id')
                    ->leftJoin('sale', 'order.id = sale.order_id')
                    ->andWhere(['sale.is_sold' => 0])
                    ->orWhere(['is', 'sale.is_sold', new Expression('NULL')]);

                $query->andFilterWhere(['order.id' => $subQuery]);
            }
        } else {
            $this->status = [ 'sold', 'open' ];
        }
    }
}
