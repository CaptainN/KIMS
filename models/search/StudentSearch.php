<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Student;

/**
 * StudentSearch represents the model behind the search form about `app\models\Student`.
 */
class StudentSearch extends Student
{
   public function attributes()
   {
      // add related fields to searchable attributes
      return array_merge(parent::attributes(), [
         'handAnchor.name',
         'bestPhoneNumber',
      ]);
   }
   
    public function rules()
    {
        return [
            [['id', 'spar_auth',
             'grapple_auth', 'active'], 'integer'],
            [['fname', 'mname', 'lname', 'kai_number', 'belt_size',
             'gi_size', 'dob', 'email', 'notes', 'prefix', 'gender',
             'handAnchor.name'], 'safe'],
            //[['anchor.id'], 'safe'],
            [['division_id'], 'safe'],
            [['bestPhoneNumber'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

   public function search($params)
   {
      $query = Student::find()
       ->joinWith('affiliations.handAnchor.day')
       ->joinWith('affiliations.handAnchor.frequency')
       ->joinWith('affiliations.school')
       ->joinWith('phones')
       ->joinWith('division')
       ->joinWith('promotions.rank')
       ->groupBy('student.id')
       ->where(['affiliation.school_id' => user()->schoolId])
        ;
      
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
      ]);
      
      // load the search form data and validate
      if (!($this->load($params) && $this->validate())) {
         return $dataProvider;
      }
      
      // we only get here if there are filter params in the GET
      
      //dump($params);
      //dump('active=', $this->active);


      // adjust the query by adding the filters
      $query->andFilterWhere([
         'dob' => $this->dob,
         
         //'contract_school_id' => $this->contract_school_id,
         'spar_auth' => $this->spar_auth,
         'grapple_auth' => $this->grapple_auth,
         'belt_size' => $this->belt_size,
         'gi_size' => $this->gi_size,
      ]);
     

      $query
         ->andFilterWhere(['student.active' => $this->active])
         ->andFilterWhere(['like', 'prefix', $this->prefix])
         ->andFilterWhere(['like', 'gender', $this->gender])
         ->andFilterWhere(['like', 'fname', $this->fname])
         ->andFilterWhere(['like', 'mname', $this->mname])
         ->andFilterWhere(['like', 'lname', $this->lname])
         ->andFilterWhere(['like', 'kai_number', $this->kai_number])
         ->andFilterWhere(['like', 'email', $this->email])
         ->andFilterWhere(['like', 'notes', $this->notes])
         ->andFilterWhere(['like', 'day.name', $this['handAnchor.name']])
         ->andFilterWhere(['like', 'student_phone.number', $this->bestPhoneNumber])
         ->andFilterWhere(['like', 'division.name', $this->division_id])
         ;
         

       

      return $dataProvider;
   }
}
