<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Affiliation;

/**
 * AffiliationSearch represents the model behind the search form about `\app\models\Affiliation`.
 */
class AffiliationSearch extends Affiliation
{
    public function rules()
    {
        return [
            [['id', 'active', 'student_id', 'school_id', 'role_id', 'hand_anchor_id', 'weapon_anchor_id'], 'integer'],
            [['start_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Affiliation::find();

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
            'school_id' => $this->school_id,
            'role_id' => $this->role_id,
            'hand_anchor_id' => $this->hand_anchor_id,
            'weapon_anchor_id' => $this->weapon_anchor_id,
            'start_date' => $this->start_date,
        ]);

        return $dataProvider;
    }
}
