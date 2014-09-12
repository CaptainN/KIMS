<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Meta;

/**
 * MetaSearch represents the model behind the search form about `app\models\Meta`.
 */
class MetaSearch extends Meta
{
    public function rules()
    {
        return [
            [['id', 'parent_id', 'child_id'], 'integer'],
            [['key', 'value', 'format', 'parent_class', 'child_class'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Meta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'child_id' => $this->child_id,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'format', $this->format])
            ->andFilterWhere(['like', 'parent_class', $this->parent_class])
            ->andFilterWhere(['like', 'child_class', $this->child_class]);

        return $dataProvider;
    }
}
