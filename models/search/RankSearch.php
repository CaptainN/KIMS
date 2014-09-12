<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rank;

/**
 * RankSearch represents the model behind the search form about `app\models\Rank`.
 */
class RankSearch extends Rank
{
    public function rules()
    {
        return [
            [['id', 'value'], 'integer'],
            [['name', 'traditional_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Rank::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'traditional_name', $this->traditional_name]);

        return $dataProvider;
    }
}
