<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MemberPackage;

/**
 * MemberPackagesSearch represents the model behind the search form of `backend\models\MemberPackage`.
 */
class MemberPackagesSearch extends MemberPackage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'refferor_id', 'package_id'], 'integer'],
            [['filling_date', 'status', 'create_at'], 'safe'],
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
        $query = MemberPackage::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'refferor_id' => $this->refferor_id,
            'package_id' => $this->package_id,
            'filling_date' => $this->filling_date,
            'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    public function search2($id)
    {
        $query = MemberPackage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'user_id' => $id,
            //'refferor_id' => $this->refferor_id,
            //'package_id' => $this->package_id,
            //'filling_date' => $this->filling_date,
            //'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

     
        return $dataProvider;
    }

}
