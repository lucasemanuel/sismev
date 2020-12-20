<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sale;
use Yii;
use yii\db\ActiveQuery;

/**
 * SaleSearch represents the model behind the search form of `app\models\Sale`.
 */
class SaleSearch extends Sale
{
    public $order_total_value;
    public $setting_search_order_total_value = 0;
    public $status = ['sold', 'canceled'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_sold', 'is_canceled', 'order_id', 'setting_search_order_total_value', 'employee_id'], 'integer'],
            [['amount_paid', 'discount', 'order_total_value'], 'number'],
            [['sale_at', 'canceled_at', 'updated_at', 'status'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'setting_search_order_total_value' => Yii::t('app', 'Setting Search Order Total Value'),
                'order_total_value' => Yii::t('app', 'Order Total Value')
            ]
        );
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

        $query->innerJoin('employee', 'sale.employee_id = employee.id');

        $this->is_sold = 1;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['sale_at' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes = array_merge($dataProvider->sort->attributes, [
            'order_id' => [
                'asc' => ['order.code' => SORT_ASC],
                'desc' => ['order.code' => SORT_DESC],
            ],
            'order_total_value' => [
                'asc' => ['order.total_value' => SORT_ASC],
                'desc' => ['order.total_value' => SORT_DESC],
            ],
            'employee_id' => [
                'asc' => ['employee.usual_name' => SORT_ASC],
                'desc' => ['employee.usual_name' => SORT_DESC],
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
            'amount_paid' => $this->amount_paid,
            'discount' => $this->discount,
            'is_sold' => $this->is_sold,
            'canceled_at' => $this->canceled_at,
            'updated_at' => $this->updated_at,
            'employee_id' => $this->employee_id
        ]);

        $query->andFilterWhere(['like', 'order.code', $this->order_id]);

        $this->filterDate($query);
        $this->filterOrderValue($query);
        $this->filterStatusSale($query);

        return $dataProvider;
    }

    private function filterDate(ActiveQuery &$query)
    {
        if (!empty($this->sale_at)) {
            $dates = explode(" - ", $this->sale_at);
            $start = Yii::$app->formatter->asDateTimeDefault($dates[0]);
            $end = Yii::$app->formatter->asDateTimeDefault($dates[1]);

            $query->andFilterWhere(['between', 'sale.sale_at', $start, $end]);
        }
    }

    private function filterOrderValue(ActiveQuery &$query)
    {
        $operator = '=';
        if (isset($this->order_total_value)) {
            if ($this->setting_search_order_total_value == 1)
                $operator = '>=';
            else if ($this->setting_search_order_total_value == 2)
                $operator = '<=';
        }

        $query->andFilterWhere([$operator, 'order.total_value', $this->order_total_value]);
    }

    private function filterStatusSale(ActiveQuery &$query)
    {
        if (!empty($this->status) && count($this->status) < 2) {
            $value = current($this->status);

            if ($value == 'canceled')
                $query->andFilterWhere(['is_canceled' => 1]);
            else
                $query->andFilterWhere(['is_canceled' => 0]);
        } else {
            $this->status = ['sold', 'canceled'];
        }
    }
}
