<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;
use yii\db\ActiveQuery;
use yii\db\Expression;

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
            [['is_deleted'], 'integer'],
            [['name', 'category_id'], 'safe'],
            [['unit_price', 'amount'], 'number'],
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
        $this->makeFiltersWhere($query);
        $this->filterName($query, $this->name);

        return $dataProvider;
    }

    public static function filterName(ActiveQuery &$query, $name)
    {
        $terms = explode(' ', $name);

        $query->leftJoin('product_variation', 'product.id = product_variation.product_id');
        $query->groupBy('product.id');

        $query->select(new Expression("product.*, concat_ws(' ', product.name, NULL, group_concat(product_variation.name SEPARATOR ' ')) full_name"));

        foreach ($terms as $term) {
            $query->andFilterHaving(['like', 'full_name', $term]);
        }
    }

    protected function makeFiltersWhere(ActiveQuery &$query)
    {
        $query->andFilterWhere([
            'unit_price' => $this->unit_price,
            'amount' => $this->amount,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'category.name', $this->category_id]);
    }
}
