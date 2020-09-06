<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operation;
use yii\db\ActiveQuery;

/**
 * OperationSearch represents the model behind the search form of `app\models\Operation`.
 */
class OperationSearch extends Operation
{
    public $setting_amount = 0;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'in_out', 'product_id', 'employee_id', 'setting_amount'], 'integer'],
            [['amount'], 'number'],
            [['reason', 'created_at'], 'safe'],
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
        $this->amountSearch($query);
        $query->andFilterWhere([
            'id' => $this->id,
            'in_out' => $this->in_out,
            'created_at' => $this->created_at,
            'product_id' => $this->product_id,
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

        $query->andFilterWhere([$operator, 'amount', $this->amount]);
    }
}
