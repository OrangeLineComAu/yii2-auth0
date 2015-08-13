<?php

namespace anli\auth0\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use anli\auth0\models\Tenant;

/**
 * TenantSearch represents the model behind the search form about `anli\auth0\models\Tenant`.
 */
class TenantSearch extends Tenant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_user_id', 'update_user_id'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Tenant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'create_user_id' => $this->create_user_id,
            'updated_at' => $this->updated_at,
            'update_user_id' => $this->update_user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
