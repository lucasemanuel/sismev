<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;
use Yii;

/**
 * EmployeeSearch represents the model behind the search form of `app\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'integer'],
            [['full_name', 'ssn', 'birthday', 'email', 'phone_number'], 'safe'],
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
        $query = Employee::find();

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
            'employee.birthday' => $this->getBirthDay(),
            'employee.is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'employee.full_name', $this->full_name])
            ->andFilterWhere(['like', 'employee.ssn', $this->ssn])
            ->andFilterWhere(['like', 'employee.email', $this->email])
            ->andFilterWhere(['like', 'employee.phone_number', $this->getPhoneNumber()]);

        return $dataProvider;
    }

    public function getBirthDay()
    {
        return $this->birthday && preg_match("/\d{2}\/\d{2}\/\d{4}/", $this->birthday)
            ? Yii::$app->formatter->asDateDefault($this->birthday)
            : $this->birthday = null;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number && (preg_match("/\(\d{2}\)\ \d{4}\-\d{4}/", $this->phone_number)
            || preg_match("/\(\d{2}\)\ \d{5}\-\d{4}/", $this->phone_number)) ? $this->phone_number
            : $this->phone_number = null;
    }
}
