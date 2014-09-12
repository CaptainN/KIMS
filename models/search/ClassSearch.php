<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AClass;

/**
 * ClassSearch represents the model behind the search form about `app\models\AClass`.
 */
class ClassSearch extends AClass
{
    public function rules()
    {
        return [
            [['id', 'day_id', 'division_id', 'room_id', 'instructor_id', 'type_id', 'frequency', 'active'], 'integer'],
            [['start_time'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AClass::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'day_id' => $this->day_id,
            'division_id' => $this->division_id,
            'room_id' => $this->room_id,
            'instructor_id' => $this->instructor_id,
            'start_time' => $this->start_time,
            'type_id' => $this->type_id,
            'frequency' => $this->frequency,
            'active' => $this->active,
        ]);

        return $dataProvider;
    }
}
