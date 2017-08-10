<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Offer;
use app\models\Advertiser;

/**
 * OfferSearch represents the model behind the search form about `app\models\Offer`.
 */
class OfferSearch extends Offer
{

    public $advertiser;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'advertiser_id'], 'integer'],
            [['offer_name', 'advertiser'], 'safe'],
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
//        $query = Offer::find()->joinWith('advertiser')
//            ->where(['like', 'advertiser.advertiser_name', 'lead']);

        $query = Offer::find();

        $query->joinWith(['advertiser']);
//        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['advertiser']=[
            'asc'=>['advertiser.advertiser_name'=>SORT_ASC],
            'desc' => ['advertiser.advertiser_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'advertiser_id' => $this->advertiser_id,
        ]);


        $query->andFilterWhere
        (['like', 'offer_name', $this->offer_name,])
        ->andFilterWhere(['like', 'advertiser_name', $this->advertiser]);

        return $dataProvider;
    }
}
