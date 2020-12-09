<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operation;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * OperationSearch represents the model behind the search form of `app\models\Operation`.
 */
class OperationSearch extends Operation
{
    public $setting_amount = 0;
    public $setting_product = 0;
    public $product_code;
    public $range_date;
    public $view_operations = ['valid'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'in_out', 'employee_id', 'setting_amount', 'setting_product'], 'integer'],
            [['amount'], 'number'],
            [['reason', 'range_date', 'view_operations', 'product_id'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'product_code' => Yii::t('app', 'Product Code'),
                'range_date' => Yii::t('app', 'Range Date'),
                'setting_amount' => Yii::t('app', 'Amount search setting'),
                'setting_product' => Yii::t('app', 'Product search setting'),
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
        $query = Operation::find();

        // add conditions that should always apply here
        $query->innerJoin('product', 'product.id = operation.product_id');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes = array_merge($dataProvider->sort->attributes, [
            'employee_id' => [
                'asc' => ['employee.full_name' => SORT_ASC],
                'desc' => ['employee.full_name' => SORT_DESC],
            ],
            'product_id' => [
                'asc' => ['product.name' => SORT_ASC],
                'desc' => ['product.name' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $this->makeFiltersWhere($query);
        $this->filterProduct($query);

        return $dataProvider;
    }

    public function filterAmount(ActiveQuery &$query)
    {
        $operator = '=';
        if (isset($this->amount)) {
            if ($this->setting_amount == 1)
                $operator = '>=';
            else if ($this->setting_amount == 2)
                $operator = '<=';
        }

        $query->andFilterWhere([$operator, 'operation.amount', $this->amount]);
    }

    public function filterDate(ActiveQuery &$query)
    {
        if (!empty($this->range_date)) {
            $dates = explode(" - ", $this->range_date);
            $start = Yii::$app->formatter->asDateTimeDefault($dates[0]);
            $end = Yii::$app->formatter->asDateTimeDefault($dates[1]);

            $query->andFilterWhere(['between', 'operation.created_at', $start, $end]);
        }
    }

    public function filterOperationsUndo(ActiveQuery &$query)
    {
        if (!empty($this->view_operations) && is_array($this->view_operations)) {
            if (in_array('undo', $this->view_operations) && !in_array('valid', $this->view_operations))
                $query->andWhere(['operation.is_deleted' => 1]);
            else if (in_array('valid', $this->view_operations) && !in_array('undo', $this->view_operations))
                $query->andWhere(['operation.is_deleted' => 0]);
        }
    }

    public function filterProduct(ActiveQuery &$query)
    {
        if (!$this->setting_product)
            $this->filterProductByName($query);
        else
            $this->filterProductByCode($query);
    }

    public function filterProductByName(ActiveQuery &$query)
    {
        $subQuery = self::createSubQueryToFilterProduct();
        $this->makeFiltersWhere($subQuery);

        $terms = explode(' ', $this->product_id);

        $query->leftJoin('product p', 'p.id = operation.product_id');
        $query->leftJoin('product_variation', 'product_variation.product_id = p.id');
        $query->groupBy('p.id');

        $query->select(new Expression("operation.*, concat(product.name, group_concat(product_variation.name SEPARATOR '  ')) full_name"));

        foreach ($terms as $term) {
            $query->andFilterHaving(['like', 'full_name', $term]);
            $subQuery->andWhere(['like', 'product.name', $term]);
        }

        $query->union($subQuery);

        $query->groupBy('operation.id');
    }

    private static function createSubQueryToFilterProduct()
    {
        $subQuery = Operation::find();

        $subQuery->innerJoin('product', 'product.id = operation.product_id');
        $subQuery->leftJoin('product_variation', 'product.id = product_variation.product_id');

        $subQuery->select(new Expression("operation.*, product.name as full_name"));

        return $subQuery;
    }

    protected function makeFiltersWhere(ActiveQuery &$query)
    {
        $this->filterOperationsUndo($query);
        $this->filterAmount($query);
        $this->filterDate($query);
        $query->andFilterWhere([
            'id' => $this->id,
            'in_out' => $this->in_out,
            'employee_id' => $this->employee_id,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);
    }
    
    public function filterProductByCode(ActiveQuery &$query)
    {
        $query->andFilterWhere([
            'product.code' => $this->product_id,
        ]);
    }
}
