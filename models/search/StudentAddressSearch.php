<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentAddress;

/**
 * StudentAddressSearch represents the model behind the search form about `\app\models\StudentAddress`.
 */
class StudentAddressSearch extends StudentAddress
{
    public function rules()
    {
        return [
            [['id', 'student_id', 'ord', 'active'], 'integer'],
            [['line1', 'line2', 'city', 'state_abbr', 'zip', 'name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = StudentAddress::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'student_id' => $this->student_id,
            'ord' => $this->ord,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'line1', $this->line1])
            ->andFilterWhere(['like', 'line2', $this->line2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state_abbr', $this->state_abbr])
            ->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
