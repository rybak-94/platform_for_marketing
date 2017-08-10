<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Macros;

/**
 * MacrosSearch represents the model behind the search form about `app\models\Macros`.
 */
class MacrosSearch extends Macros
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'offer_id'], 'integer'],
            [['token_key', 'token_value', 'offer_name'], 'safe'],
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
        $query = Macros::find();

        // add conditions that should always apply here

        if (array_key_exists('offer_id', $_GET)){
            $offer_id = $_GET['offer_id'];
        }



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
            'offer_id' => $this->offer_id,
        ]);

        $query->andFilterWhere(['like', 'token_key', $this->token_key])
            ->andFilterWhere(['like', 'token_value', $this->token_value]);

        return $dataProvider;
    }
}
