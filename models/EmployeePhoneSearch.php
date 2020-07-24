<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeePhone;

/**
 * EmployeePhoneSearch represents the model behind the search form of `app\models\EmployeePhone`.
 */
class EmployeePhoneSearch extends EmployeePhone
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'phone_id'], 'integer'],
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
        $query = EmployeePhone::find();

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
            'employee_id' => $this->employee_id,
            'phone_id' => $this->phone_id,
        ]);

        return $dataProvider;
    }
}
