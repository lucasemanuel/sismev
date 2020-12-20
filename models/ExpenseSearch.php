<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Expense;
use Yii;

/**
 * ExpenseSearch represents the model behind the search form of `app\models\Expense`.
 */
class ExpenseSearch extends Expense
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['is_paid'], 'boolean'],
            [['name', 'description', 'payday', 'paid_at', 'created_at', 'updated_at'], 'safe'],
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
        $query = Expense::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['payday' => SORT_DESC]],
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
            'payday' => $this->getPayday(),
            'is_paid' => $this->is_paid,
            'paid_at' => $this->getPaidAt(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'expense.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public function getPaidAt()
    {
        return $this->paid_at && preg_match("/\d{2}\/\d{2}\/\d{4}/", $this->paid_at)
            ? Yii::$app->formatter->asDateDefault($this->paid_at)
            : $this->paid_at = null;
    }

    public function getPayday()
    {
        return $this->payday && preg_match("/\d{2}\/\d{2}\/\d{4}/", $this->payday)
            ? Yii::$app->formatter->asDateDefault($this->payday)
            : $this->payday = null;
    }
}
