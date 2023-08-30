<?php

namespace common\modules\SubscriptionModule\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\SubscriptionModule\models\Subscription;

/**
 * SubscriptionSearch represents the model behind the search form of `common\modules\SubscriptionModule\models\Subscription`.
 */
class SubscriptionSearch extends Subscription
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_block', 'created_at', 'updated_at'], 'integer'],
            [['event', 'recipient'], 'safe'],
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
        $query = Subscription::find();

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

        $query->andFilterWhere(['is_block' => $this->is_block]);
        $query->andFilterWhere(['event' => $this->event]);
        $query->andFilterWhere(['like', 'recipient', $this->recipient]);

        return $dataProvider;
    }
}
