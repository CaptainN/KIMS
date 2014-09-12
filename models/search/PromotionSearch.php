<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promotion;

/**
 * PromotionSearch represents the model behind the search form about `\app\models\Promotion`.
 */
class PromotionSearch extends Promotion
{
    public function rules()
    {
        return [
            [['id', 'active', 'student_id', 'rank_id', 'testing_session_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Promotion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'student_id' => $this->student_id,
            'rank_id' => $this->rank_id,
            'date' => $this->date,
            'testing_session_id' => $this->testing_session_id,
        ]);

        return $dataProvider;
    }
}
