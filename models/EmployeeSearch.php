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
            [['id', 'is_manager', 'is_deleted', 'address_id', 'company_id'], 'integer'],
            [['full_name', 'usual_name', 'ssn', 'birthday', 'email', 'password', 'created_at', 'updated_at', 'deleted_at', 'phone_number'], 'safe'],
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
            'employee.id' => $this->id,
            'employee.birthday' => $this->getBirthDay(),
            'employee.is_manager' => $this->is_manager,
            'employee.is_deleted' => $this->is_deleted,
            'employee.created_at' => $this->created_at,
            'employee.updated_at' => $this->updated_at,
            'employee.deleted_at' => $this->deleted_at,
            'employee.address_id' => $this->address_id,
            'employee.company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'employee.full_name', $this->full_name])
            ->andFilterWhere(['like', 'employee.usual_name', $this->usual_name])
            ->andFilterWhere(['like', 'employee.ssn', $this->ssn])
            ->andFilterWhere(['like', 'employee.email', $this->email])
            ->andFilterWhere(['like', 'employee.phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'employee.password', $this->password]);

        return $dataProvider;
    }

    public function getBirthDay()
    {
        return isset($this->birthday)
            ? Yii::$app->formatter->asDateDefault($this->birthday)
            : null;
    }
}
