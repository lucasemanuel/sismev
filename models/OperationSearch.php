<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operation;
use Yii;
use yii\db\ActiveQuery;

/**
 * OperationSearch represents the model behind the search form of `app\models\Operation`.
 */
class OperationSearch extends Operation
{
    public $setting_amount = 0;
    public $product_code;
    public $range_date;
    public $view_operations = ['valid'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'in_out', 'product_id', 'product_code', 'employee_id', 'setting_amount'], 'integer'],
            [['amount'], 'number'],
            [['reason', 'range_date', 'view_operations'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'product_code' => Yii::t('app', 'Product code'),
            'range_date' => Yii::t('app', 'Range Date'),
            'setting_amount' => Yii::t('app', 'Setting amount'),
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
        $query = Operation::find();

        // add conditions that should always apply here
        $query->innerJoin('product', 'product.id = operation.product_id');
        
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
        $this->filterOperationsUndo($query);
        $this->amountSearch($query);
        $this->dateSearch($query);
        $query->andFilterWhere([
            'id' => $this->id,
            'in_out' => $this->in_out,
            'product_id' => $this->product_id,
            'product.code' => $this->product_code,
            'employee_id' => $this->employee_id,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }

    public function amountSearch(ActiveQuery &$query)
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

    public function dateSearch(ActiveQuery &$query)
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
                $query->deleted();
            else if (in_array('valid', $this->view_operations) && !in_array('undo', $this->view_operations))
                $query->notDeleted();
        }
    }
}
