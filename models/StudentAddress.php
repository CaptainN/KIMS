<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_address".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $line1
 * @property string $line2
 * @property string $city
 * @property string $state_abbr
 * @property string $zip
 * @property string $name
 * @property integer $ord
 * @property integer $active
 *
 * @property Student $student
 */
class StudentAddress extends \app\components\MetaModel
{

   /**
    * @inheritdoc
    */
   public static function tableName()
   {
      return 'student_address';
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return [
         [['student_id'], 'required'],
         [['student_id', 'ord', 'active'], 'integer'],
         [['line1', 'line2'], 'string', 'max' => 64],
         [['city', 'name'], 'string', 'max' => 32],
         [['state_abbr'], 'string', 'max' => 2],
         [['zip'], 'string', 'max' => 10]
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'student_id' => 'Student ID',
         'line1' => 'Line1',
         'line2' => 'Line2',
         'city' => 'City',
         'state_abbr' => 'State Abbr',
         'zip' => 'Zip',
         'name' => 'Name',
         'ord' => 'Ord',
         'active' => 'Active',
      ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getStudent()
   {
      return $this->hasOne(Student::className(), ['id' => 'student_id']);
   }

}
