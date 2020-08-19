<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_deleted'], 'integer'],
            [['code', 'name', 'created_at', 'updated_at', 'deleted_at', 'category_id'], 'safe'],
            [['unit_price', 'amount', 'max_amount', 'min_amount'], 'number'],
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
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->sort->attributes = array_merge($dataProvider->sort->attributes, [
            'category_id' => [
                'asc' => ['category.name' => SORT_ASC],
                'desc' => ['category.name' => SORT_DESC],
            ],
        ]); 
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'unit_price' => $this->unit_price,
            'amount' => $this->amount,
            'max_amount' => $this->max_amount,
            'min_amount' => $this->min_amount,
            'is_deleted' => $this->is_deleted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'product.code', $this->code])
            ->andFilterWhere(['like', 'category.name', $this->category_id])
            ->andFilterWhere(['like', 'product.name', $this->name]);
            

        return $dataProvider;
    }
}
