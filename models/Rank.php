<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rank".
 *
 * @property integer $id
 * @property string $name
 * @property integer $ord
 * @property string $traditional_name
 */
class Rank extends \app\components\MetaModel
{

   /**
    * @inheritdoc
    */
   public static function tableName()
   {
      return 'rank';
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return [
         [['ord'], 'integer'],
         [['traditional_name'], 'required'],
         [['name', 'traditional_name'], 'string', 'max' => 45],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'name' => 'Name',
         'next.name' => 'Next Rank',
         'ord' => 'Ord',
         'traditional_name' => 'Traditional Name',
      ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getNext()
   {
      return Rank::find()->onCondition('ord > :cur', ['cur' => $this->ord]);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getStudentRanks()
   {
      return $this->hasMany(StudentRank::className(), ['rank_id' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getStudents()
   {
      return $this->hasMany(Student::className(), ['id' => 'student_id'])
        ->via('assignedRanks');
   }

   /**
    * @return integer the number of students with this rank.
    */
   public function getStudentCount()
   {
      return $this->getStudents()->count();
   }

   public static function getMap()
   {
      return ArrayHelper::map(Rank::find()
         ->where(['active' => 1])->orderBy('ord')->all(), 'id', 'name');
   }
   
}
