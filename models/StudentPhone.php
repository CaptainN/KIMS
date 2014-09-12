<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_phone".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $number
 * @property string $name
 * @property integer $ord
 * @property integer $active
 *
 * @property Student $student
 */
class StudentPhone extends \app\components\MetaModel
{
   /**
    * @inheritdoc
    */
   public static function tableName()
   {
      return 'student_phone';
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return [
         [['number'], 'required'],
         [['student_id', 'ord', 'active'], 'integer'],
         [['name', 'number'], 'string'],
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
         'number' => 'Number',
         'name' => 'Name',
         'ord' => 'Order',
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
   
   public function getFullName()
   {
      return $this->number . ' - ' . $this->name;
   }
}
