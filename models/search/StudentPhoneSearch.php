<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentPhone;

/**
 * StudentPhoneSearch represents the model behind the search form about `app\models\StudentPhone`.
 */
class StudentPhoneSearch extends StudentPhone
{
   public function rules()
   {
       return [
           [['id', 'ord', 'student_id', 'active'], 'integer'],
           [['number', 'name'], 'safe'],
       ];
   }

   public function scenarios()
   {
       // bypass scenarios() implementation in the parent class
       return Model::scenarios();
   }

   public function search($params)
   {
      $query = StudentPhone::find();
      
      $query->orderBy(['ord' => SORT_ASC]);

      $dataProvider = new ActiveDataProvider([
         'query' => $query,
      ]);

      if (!($this->load($params) && $this->validate())) {
          return $dataProvider;
      }

      $query->andFilterWhere([
         'id' => $this->id,
         'ord' => $this->ord,
         'student_id' => $this->student_id,
         'active' => $this->active,
      ]);

      $query->andFilterWhere(['like', 'number', $this->number])
         ->andFilterWhere(['like', 'name', $this->name]);

      return $dataProvider;
   }
}
